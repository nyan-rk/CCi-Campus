<?php

    // Return the user info using its name
    function getFromNickName($nickName,$db)
    {
        $req=$db->prepare('SELECT * FROM user WHERE nickname_user= :NAME');
        $req->execute(array('NAME' => $nickName));
        return $req;
    }