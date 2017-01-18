<?php

class mb90_formGen
{
    /*function getFormMarkup($formName, $mode, $id)
    {
        $html = "";
        switch ($formName) {
            case "exercises":
                $html = $this->ExerciseFormMarkup($mode, #id);
                break;
            default:
                $html = "no data";
                break;
        }
        return $html;
    }*/
    
    
    function translateID($tablename)
    {
        
    }
    
    function ExerciseFormMarkup($mode, $id)
    {
        if( $mode == "add")
        {
            $html = file_get_contents('../wp-content/plugins/exercise-menu/inc/exercise-form/form.html', FILE_USE_INCLUDE_PATH);
            $processedHTML = ProcessExerciseHTML($html);
        }
        else if($mode == "edit")
        {
            $html = file_get_contents('../wp-content/plugins/exercise-menu/inc/exercise-form/form.html', FILE_USE_INCLUDE_PATH);
        }
        else if($mode == "list")
        {

        }
        return $html;
    }
    
    function ProcessExerciseHTML($html, $id)
    {
        
    }
}

?>
