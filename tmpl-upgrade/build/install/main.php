<?php

// DO NOT EDIT THIS FILE.  THIS FILE WAS AUTO-GENERATED BY ReleaseMerge.

//
// build-install script.
//
// Run this to build the "install" portion.
//



// P R O C E D U R E S //////////////////////////////////////////////////////////////////////////////////////////////////////

    function generate_install_procedure($dirname)
    {
        //
        // Generate code.
        //
            $code  = '        ';
            $code .= 'function task_install()';
            $code .= "\n";

            $code .= '        ';
            $code .= '{';
            $code .= "\n";

            $code .= "\n";

            $code .= '        ';
            $code .= '        ';
            $code .= 'task_upgrade();';
            $code .= "\n";

            $code .= "\n";

            $code .= sub_generate_directories($dirname, $dirname.'/');

            $code .= '        ';
            $code .= '}';
            $code .= "\n";

        //
        // Return.
        //
            return $code;
    }

//=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=//

    function sub_generate_directories($dirname, $remove_prefix)
    {
        //
        //
        //
            $code = '';

            $dir = dir($dirname);
            if (  !isset($dir) || FALSE === $dir || !is_object($dir)  ) {
    /////////// RETURN
                return FALSE;
            }

            while (  FALSE !== ($x = $dir->read())  ) {

                if (  '.' == $x || '..' == $x || '.svn' == $x  ) {
            /////// CONTINUE
                    continue;
                }

                $path = $dirname . '/' . $x;

                $code .= sub_generate($path, $remove_prefix);

            } // while

        //
        // Return.
        //
            return $code;
    }

//=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=//

    function sub_generate($path, $remove_prefix)
    {
        //
        // Generate code.
        //
            $code = '';

            $x = substr($path,strlen($remove_prefix));

            if (  is_dir($path)  ) {
                $code .= '                ';
                $code .= '@mkdir('. var_export($x,TRUE)  .');';
                $code .= "\n";

// ##### TODO: chmod

                $code .= sub_generate_directories($path, $remove_prefix);

            } elseif (  is_file($path)  ) {
                $data = file_get_contents($path);
                $data = gzdeflate($data);

                $code .= '                ';
                $code .= '@file_put_contents( '. var_export($x,TRUE);
                $code .= "\n";
                $code .= '                ';
                $code .= '                  , gzinflate('. var_export($data,TRUE) .'));';
                $code .= "\n";
            }


        //
        // Return.
        //
            return $code;

    }

////////////////////////////////////////////////////////////////////////////////////////////////////// P R O C E D U R E S //



//
// M A I N
//

    $dirname = $argv[1];
    if (  !isset($dirname) || !is_string($dirname) || '' == trim($dirname)  ) {
/////// EXIT
        exit(1);
    }
    if (  !file_exists($dirname) || !is_dir($dirname)  ) {
/////// EXIT
        exit(1);
    }


    $code = generate_install_procedure($dirname);
    if (  FALSE === $code || !is_string($code) || '' == trim($code)  ) {
        // Error
/////// EXIT
        exit(1);
    }


    print($code);



