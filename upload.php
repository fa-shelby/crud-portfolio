<?php

function uploadImage(): string {
    if (!empty($_FILES['img']['name'])) {

        $imgLocation = 'public/upload/' . uniqid() . '-' . basename($_FILES['img']['name']);
        move_uploaded_file($_FILES['img']['tmp_name'], __DIR__ . '/' . $imgLocation);

    }else{
        $imgLocation = 'null';
    }

    return $imgLocation;
}

function uploadLink(): string {
    if (!empty($_FILES['link']['name'])) {

        $linkLocation = 'public/upload/' . uniqid() . '-' . basename($_FILES['link']['name']);
        move_uploaded_file($_FILES['link']['tmp_name'], __DIR__ . '/' . $linkLocation);

    }else{
        $linkLocation = 'null';
    }

    return $linkLocation;
}
