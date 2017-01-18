
<div class="form_container">

    <form id="form_965839" class="appnitro"  method="post" action="">

        <?php
        //echo "[".$progSelected."]";
        //foreach( $wpdb->get_results("SELECT * FROM mb90_prog_exercises WHERE id LIKE' . $id . ';") as $key => $row) 
        $progExercises = $wpdb->get_results("SELECT * FROM mb90_prog_exercises WHERE ProgrammeID = " .$progSelected. " ORDER BY ProgrammeID, ExerciseDay", OBJECT);
        //echo "[".$wpdb->num_rows."]";
        if( $wpdb->num_rows > 0 )
        {
            echo '<table id="ex-table" class="ex-input-table"><thead>';
            $rowCount = 0;
            foreach( $progExercises as $key => $row)
            {
                
                $rowCount++;
                //echo "here";
                $my_column = $row->column_name;
                
                if( $rowCount % 10 == 1) // print column headers every 10 rows
                {
                    ?>
                <tr class="table-header">
                    
                    <td><div class="form-cell"><label class="description" for="element_7">Programme:</label></div></td>
                    <td><div class="form-cell"><label class="description" for="element_7">Exercise:</label></div></td>
                    <td><div class="form-cell"><label class="description" for="element_7">Day of Exercise:</label></div></td>
                    <td><div class="form-cell"><label class="description" for="element_7">Reps:</label></div></td>
                    <td><div class="form-cell"><label class="description" for="element_7">Minutes:</label></div></td>
                    <td><div class="form-cell"><label class="description" for="element_7">Details:</label></div></td>
                    <td><div class="form-cell"><label class="description" for="element_7">10 Day Challenge Phase:</label></div></td>
                    <td><div class="form-cell"><label class="description" for="element_7">Message:</label></div></td>
                </tr>
                     <?php
                    
                }
            ?>  
                <tr>
                        <!--<div class="ex-input-row"> <!-- start input row -->
                    <td class="td-form-cell">
                        <div class="input-wrapper">
                        <select class="element select medium" id="ProgrammeID-<?=$rowCount?>" name="prog-select" onChange="this.form.submit();" DISABLED> 
                                <option value=""<?=$progSelected == '' ? ' selected="selected"' : '';?>>-- Please Select --</option>
                                <?php
                                    foreach( $wpdb->get_results("SELECT * FROM mb90_programmes ORDER BY ID")as $key => $progRow)
                                    { 
                                ?>
                                    <option value="<?=$progRow->ID;?>"<?=$progSelected == $progRow->ID ? ' selected="selected"' : '';?>><?=$progRow->ProgrammeType;?></option>
                                <?php } ?>
                        </select>
                        </div> 
                    </td>

                    <td class="td-form-cell">
                        <div class="input-wrapper">
                         <select class="element select medium" id="ExerciseID-<?=$rowCount?>" name="prog-select" onChange="this.form.submit();"> 
                                <option value=""<?=$progSelected == '' ? ' selected="selected"' : '';?>>-- Please Select --</option>
                                <?php
                                    foreach( $wpdb->get_results("SELECT * FROM mb90_exercise_types ORDER BY ID")as $key => $exTypeRow)
                                    { 
                                ?>
                                    <option value="<?=$exTypeRow->ID;?>"<?=$row->ExerciseID == $exTypeRow->ID ? ' selected="selected"' : '';?>><?=$exTypeRow->ExerciseName;?></option>
                                <?php } ?>
                        </select>

                        </div> 
                    </td>

                    <td class="td-form-cell">
                        <div class="input-wrapper">
                        <select class="element select medium" id="ExerciseDay-<?=$rowCount?>" name="element_4"> 
                                <?php
                                    for( $day = 1; $day <= 90; $day++ )
                                    { 
                                ?>
                                    <option value="<?=$day;?>"<?=$row->ExerciseDay == $day ? ' selected="selected"' : '';?>><?=$day;?></option>
                                <?php } ?>

                        </select>
                        </div> 
                    </td>

                    <td class="td-form-cell">
                        <div class="input-wrapper">
                            <input id="Reps-<?=$rowCount;?>" value="<?=$row->Reps;?>" />
                        </div> 
                    </td>

                    <td class="td-form-cell">

                        <div class="input-wrapper">
                            <input id="NumMinsForReps-<?=$rowCount;?>" value="<?=$row->NumMinsForReps;?>" />
                        </div> 
                    </td>


                    <td class="td-form-cell">

                            <div class="input-wrapper">
                                <input id="SelfAssesssment--<?=$rowCount;?>" name="element_7_1" class="element checkbox" type="checkbox" value="1" />
                                <label class="choice" for="element_7_1">30 Day Self Assessment</label><br />
                                <input id="10DayChallenge-<?=$rowCount;?>" name="element_7_2" class="element checkbox" type="checkbox" value="1" />
                                <label class="choice" for="element_7_2">10 Day Challenge</label>
                            </div> 

                    </td>

                    <td class="td-form-cell">
                        <div class="input-wrapper">
                        <select class="element select medium" id="10DayChallengePhase--<?=$rowCount;?>" name="element_8"> 
                                <option value="" selected="selected"></option>
                                <?php
                                    for( $phase = 1; $phase <= 9; $phase++ )
                                    { 
                                ?>
                                    <option value="<?=$phase;?>"<?=$row->ExerciseDay == $phase ? ' selected="selected"' : '';?>><?=$phase;?></option>
                                <?php } ?>

                        </select>
                        </div> 

                    </td>

                    <td class="td-form-cell">
                        <div class="input-wrapper">
                                <textarea id="Message-<?=$rowCount;?>" name="element_1" class="element textarea medium"><?=$row->Message;?></textarea> 
                        </div> 
                    </td>



                    <td class="td-form-cell">
                        <input type="hidden" name="form_id" value="965839" />
                        <input id="saveForm" class="button_text" type="submit" name="submit" value="Save" />
                    </td>

                <!--</div> <!-- end input row -->
            </tr>
            <?php
            }
        }
        else
        {
            echo "No exercises found for selected Programme";
        }
        ?>

    </thead>
    </table>
    </form>	



</div> <!-- end form container -->
