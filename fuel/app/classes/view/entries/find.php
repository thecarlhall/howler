<?php
class View_Entries_Find extends ViewModel
{
	public function view()
	{
		$type = $this->type;
		$$type = Input::get($type);
		$results = Model\Entry::find()
			->where($type, $$type)
			->order_by('album')
			->order_by('artist')
			->order_by('track')
			->get();
		$this->entries = $results;
	}
}