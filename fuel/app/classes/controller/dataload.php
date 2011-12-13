<?php
class Controller_Dataload extends Controller {

	public function action_index()
	{
		if (Input::method() == 'POST')
		{
			// process post parameters
			$start = microtime(true);
			$dir = Input::post('dir');
			$update = Input::post('update');
			$count = $this->process_dir($dir, $update == '1');

			$end = microtime(true);
			echo "Processed $count entries in ".($end - $start)." milliseconds.";
		}
		else
		{
			return Response::forge(View::forge('dataload/index'));
		}
	}

	private function process_dir($start_dir, $update = false, $count = 0, $max_count = -1)
	{
		require_once(APPPATH.'classes/getid3/getid3.php');
		$id3 = new getID3;

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
				echo "<b>$fd</b><br/>";
				flush();
				$count = $this->process_dir($full_path, $count, $max_count);
			}
			elseif (is_file($full_path))
			{
				// open the file to read the id3
				$metadata = $id3->analyze($full_path);
				getid3_lib::CopyTagsToComments($metadata);
				$comments = $metadata['comments'];

				// get existing model or create one
				$entry = Model\Entry::find()->where('path', $full_path)->get_one();
				if ($entry == null) {
					echo "Creating entry for $fd<br/>";
					$entry = Model\Entry::forge(array('path' => $full_path));
				} else {
					echo "Updating entry for $fd<br/>";
				}
				flush();

				// update data on the model
				$entry->size = filesize($full_path);
				array_key_exists('track', $comments) and $entry->track = $comments['track'][0];
				array_key_exists('artist', $comments) and $entry->artist = $comments['artist'][0];
				array_key_exists('album', $comments) and $entry->album = $comments['album'][0];
				array_key_exists('title', $comments) and $entry->title = $comments['title'][0];
				array_key_exists('genre', $comments) and $entry->genre =$comments['genre'][0];
				$entry->save();

				$count++;
			}
		}
		return $count;
	}
}
