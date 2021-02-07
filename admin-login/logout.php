<?php


setcookie('aid', '', time() - 3600);
header('location:login?msg=logout successfully');
