<?php

class dataHandler{
    public function load(){
        $res = $this->getDemoList();
        return $res;
    }

    private static function getDemoList(){
        $demoList = [
            "do homework", "eat", "study", "do more homework", "shower", "get some sleep", "dream of homework"
        ];
        return $demoList;
    }
}
?>