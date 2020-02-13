<?php 


use Database\Database;

class Model extends Database{
	

	function hasMany($model, $foreignkey, $primarykey='id'){
		$model = new $model;
		$result = [];
		foreach($this->get() as $index => $array){

			$array[strtolower(get_class($model))] = $model->where($foreignkey, $array[$primarykey])->get();
			$result[$index] = $array; 
		}

		return $result;
	}

	function belongsTo($model, $foreignkey, $primarykey='id'){	
		$model = new $model;
		$result = [];
	
		foreach($this->get() as $index => $array){ 
			$array[strtolower(get_class($model))] = $model->where($primarykey, $array[$foreignkey])->get();
			$result[$index] = $array; 
		}

		return $result;
	}


}