<?php
define('CHUNK_SIZE', 1024 * 1024);

class Controller_Entries extends Controller
{

	public function action_view($id)
	{
		$entry = Model\Entry::find($id);
		if (!isset($entry))
		{
			throw new HttpNotFoundException();
		}

		return View::forge('entries/view', array('entry' => $entry));
	}

	public function action_list($type)
	{
		$results = DB::select_array(array($type, DB::expr('COUNT(*) as count')))
				->from('entries')
				->order_by($type)
				->group_by($type)
				->cached(3600)
				->execute();
		$data = array('type' => $type, 'entries' => $results->as_array());
		return View::forge('entries/list', $data);
	}

	public function action_find($type)
	{
		$$type = Input::get($type);
		$results = Model\Entry::find()
				->where($type, $$type)
				->order_by('album')
				->order_by('artist')
				->order_by('track')
				->get();
		$data = array('type' => $type, $type => $$type, 'entries' => $results);
		return View::forge('entries/find', $data);
	}

	public function action_stream($id)
	{
		$entry = Model\Entry::find($id);
		if (!isset($entry))
		{
			throw new HttpNotFoundException();
		}

		$path = $entry->path;
		if (!file_exists($path))
		{
			throw new HttpNotFoundException();
		}

		header('Content-Type: application/octet-stream');
		header('Content-Length: '.$entry->size);
		$this->_readfile_chunked($path);
	}

	public function action_metadata($id)
	{
		$entry = Model\Entry::find($id);
		if (!isset($entry))
		{
			throw new HttpNotFoundException();
		}

		$output = array();
		$output['artist'] = $entry->artist;
		$output['album'] = $entry->album;
		$output['title'] = $entry->title;
		$output['genre'] = $entry->genre;
		$output['track'] = $entry->track;

		$json = json_encode($output);
		$resp = Response::forge($json);
		$resp->set_header('Content-Type', 'application/json');
		return $resp;
	}

	// ---------- helper functions ----------------------------------------------
	private function _readfile_chunked($path) {
		$fp = fopen($path, 'r');
		if ($fp === false) {
			throw new HttpNotFoundException();
		}

		$buffer = '';
		while (!feof($fp)) {
			$buffer = fread($fp, CHUNK_SIZE);
			echo $buffer;
			ob_flush();
			flush();
		}
		$status = fclose($handle);
		return $status;
	}
}
