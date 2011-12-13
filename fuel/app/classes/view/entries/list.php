<?php
class View_Entries_List extends ViewModel
{
	public function view()
	{
		$results = DB::select_array(array($this->type, DB::expr('COUNT(*) as count')))
			->from('entries')
			->order_by($this->type)
			->group_by($this->type)
			->execute();
		$this->entries = $results->as_array();
	}
}
