<?php
/**
 * Created by Bryan Carraghan.
 * Date: 12/17/13
 * Time: 4:11 PM
 */
?>
<!-- Author: Bryan Carraghan -->
<div id="adv-stopwatch">
  <div id="timer-container">
    <div id="timer-left">
    <div id="timer">00:00:00<span>.00</span></div>
      <div id="watch-buttons">
        <input id="start" type="button" class="button" value="Start" />
        <input id="stop" type="button" class="button" value="Stop" />
        <input id="split" type="button" class="button" value="Split" />
        <input id="reset" type="button" class="button" value="Reset" />
      </div>
    </div>
    <div id="timer-right">
      <div id="lap-timer">00:00:00<span>.00</span></div>
      <div id="checkboxes">
        <input type="checkbox" name="show-lap-time" value="show-lap-time" id="show-lap-time" checked><label for="show-lap-time">Vis split tid</label><br />
        <input type="checkbox" name="show-lap-list" value="show-lap-list" id="show-lap-list" checked><label for="show-lap-list">Vis split liste</label>
      </div>
    </div>
  </div>


  <table>
    <tr>
      <th class="row-num">&nbsp;</th>
      <th>Type</th>
      <th class="label-insert">Label</th>
      <th class="lap">Lap</th>
      <th>Total</th>
      <th>Actual</th>
      <th>&nbsp;</th>
    </tr>
  </table>

</div>