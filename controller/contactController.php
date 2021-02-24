<?php

    function formBuilder()
    {
        echo "<div class='container'>
        <h2><strong>".CONT['title']."</strong></h2>
        <label for='name'><strong>".CONT['name']."</strong></label>
        <input type='text' name='name' id='name'>
        <div class='errormessage' id='errorname'>".CONT['errorname']."</div>
        <label for='firstname'><strong>Prénom</strong></label>
        <input type='text' name='firstname' id='firstname'>
        <div class='errormessage' id='errorfirstname'>".CONT['errorfirstname']."</div>
        <label for='mail'><strong>".CONT['mail']."</strong></label>
        <input type='text' name='mail' id='mail'>
        <div class='errormessage' id='errormail1'>".CONT['errormail1']."</div>
        <div class='errormessage' id='errormail2'>".CONT['errormail2']."</div>
        <label for='subject'><strong>".CONT['subject']."</strong></label>
        <input type='text' name='subject' id='subject'>
        <div class='errormessage' id='errorsubject'>".CONT['errorsubject']."</div>
        <label for='message'><strong>".CONT['message']."</strong></label>
        <textarea name='message' id='message' rows='5'></textarea>
        <div class='errormessage' id='errormessage'>".CONT['errormessage']."</div>
        <button id='send'><h3>".CONT['send']."</h3></button>
    </div>
    <div class='modal fade' id='messageSentModal' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
        <div class='modal-dialog modal-dialog-centered' role='document'>
            <div class='modal-content'>
                <div class='modal-header'>
                    <h5 class='modal-title'>".CONT['sentTitle']."</h5>
                </div>
                <div class='modal-body'>".CONT['sentBody']."
                </div>
                <div class='modal-footer'>
                    <button type='button' id='messageSentButton' data-dismiss='modal' class='btn btn-primary'>".CONT['sentButton']."</button>
                </div>
            </div>
        </div>
    </div>
    <div class='modal fade' id='messageNotSentModal' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
        <div class='modal-dialog modal-dialog-centered' role='document'>
            <div class='modal-content'>
                <div class='modal-header'>
                    <h5 class='modal-title'>".CONT['notSentTitle']."</h5>
                </div>
                <div class='modal-body'>".CONT['notSentBody']."</div>
                <div class='modal-footer'>
                    <button type='button' id='messageNotSentButton' data-dismiss='modal' class='btn btn-primary'>".CONT['notSentButton']."</button>
                </div>
            </div>
        </div>
    </div>";
    }