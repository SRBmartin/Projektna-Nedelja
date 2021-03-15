<?php
    ini_set('session.gc_maxlifetime', 3660);
    ini_set('session.gc_probability',1);
    ini_set('session.gc_divisor', 100);
    session_save_path('/home/muharemo/vars/ss-strg/');
    session_start();