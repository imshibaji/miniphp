<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php __($title ?? APP['name'] ?? 'Head Part') ?></title>
        <meta name='description' content='<?php __($description ?? 'This is a dynamic page example.') ?>'>
        <link rel='stylesheet' href="<?php assets('css/bootstrap.min.css') ?>">
        <link rel='stylesheet' href='<?php assets('css/styles.css') ?>'>
    </head>
    <body>