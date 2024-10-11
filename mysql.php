<?php
$conn = mysqli_connect('127.0.0.1', 'u952575849_1', 'Anhngoc123!@#', 'u952575849_1');
$sql = 'select * from `notifications` where `user_id` is null and `admin_id` is null and `status` = 0';
$query = mysqli_query($conn,$sql);
$data = mysqli_fetch_assoc($query);
echo "<pre>";print_r($data);echo "</pre>";