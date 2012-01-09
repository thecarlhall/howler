<?php
class Controller_Dataload extends Controller
{
	/** TODO Add all files to the db first then process id3 in batches */

	public function action_index()
	{
		if (Input::method() == 'POST')
		{
			// process post parameters
			$dir = Input::post('dir');
			$update = Input::post('update', '0') == '1';

			if (is_dir($dir))
			{
				$start = microtime(true);
				$count = $this->process_dir($dir, $update);
				$end = microtime(true);

				$msg = "Processed $count entries in ".($end - $start)." seconds.";
				Log::info($msg);

				return Response::forge("$msg<br/>");
			}
			else
			{
				throw new HttpNotFoundException();
			}
		}
		else
		{
			return Response::forge(View::forge('dataload/index'));
		}
	}

	private function process_dir($start_dir, $update = false)
	{
		set_time_limit(0);
		ini_set('memory_limit', '256M');
		require_once(APPPATH.'classes/getid3/getid3.php');
		$id3 = new getID3;

		$count = 0;

		# walk the directory
		$files_dirs = scandir($start_dir);
		foreach ($files_dirs as $fd)
		{
			if ($fd == '.' or $fd == '..')
			{
				continue;
			}

			$full_path = "$start_dir/$fd";
			if (is_dir($full_path))
			{
				$count += $this->process_dir($full_path, $update);
			}
			elseif (is_file($full_path))
			{
				if (pathinfo($fd, PATHINFO_EXTENSION) != 'mp3')
				{
					continue;
				}

				// get existing model or create one
				$entry = Model\Entry::find()->where('path', $full_path)->get_one();
				if ($entry == null) {
					$msg = "Creating entry for $full_path";
					Log::info($msg);
					echo "$msg<br/>";
					$entry = Model\Entry::forge(array('path' => $full_path));
				} elseif ($update) {
					$msg = "Updating entry for $full_path";
					Log::info($msg);
					echo "$msg<br/>";
				} else {
					continue;
				}

				$entry->size = filesize($full_path);

				// open the file to read the id3
				$metadata = $id3->analyze($full_path);
				getid3_lib::CopyTagsToComments($metadata);
				if (array_key_exists('comments', $metadata))
				{
					$comments = $metadata['comments'];

					// update data on the model
					array_key_exists('track', $comments) and $entry->track = $comments['track'][0];
					array_key_exists('artist', $comments) and $entry->artist = $comments['artist'][0];
					array_key_exists('album', $comments) and $entry->album = $comments['album'][0];
					array_key_exists('title', $comments) and $entry->title = $comments['title'][0];
					array_key_exists('genre', $comments) and $entry->genre =$comments['genre'][0];
				}
				else
				{
					$entry->title = $fd;
					$entry->artist = 'busted';
					$entry->album = 'busted';
				}
				$entry->save();
				$count++;

				if ($count % 100 == 0) {
					flush();
				}
			}
		}
		return $count;
	}
}
