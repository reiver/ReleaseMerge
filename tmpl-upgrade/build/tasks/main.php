<?php

// DO NOT EDIT THIS FILE.  THIS FILE WAS AUTO-GENERATED BY ReleaseMerge.

//
// build/tasks/main.php
//


//
// M A I N
//


    //
    // Figure out paths.
    //
        //
        // Figure out the "root" path to the build scripts.
        //
            $build_path = dirname(__FILE__).'/..';
            $build_path = realpath($build_path);

        //
        // Figure out the "root" path to the scripts scripts.
        //
            $tasks_path = getcwd() . '/tasks';

        //
        // Figure out the "root" path to the scripts scripts.
        //
            $parts_path = getcwd() . '/parts';


    //
    // Construct code.
    //
        $code = '';


        //
        // Incorporate the "tasks" info the code.
        //

            $tasks = array();

            $tasks_dir = dir($tasks_path);
            while (  FALSE !== ($x = $tasks_dir->read())  ) {

                if (  '.' == $x || '..' == $x  ) {
            /////// CONTINUE
                    continue;
                }

                if (  '.svn' == $x  ) {
            /////// CONTINUE
                    continue;
                }

                $dir_path = $tasks_path.'/'.$x;

                if (  !is_dir($dir_path)  ) {
            /////// CONTINUE
                    continue;
                }

                $file_path = $dir_path.'/'.'main.php.part';

                $code .= '//=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=//'."\n";
                $code .= "\n";
                $code .= file_get_contents($file_path);
                $code .= "\n";


                $tasks[$x] = array();
                $tasks[$x]['canonical name'] = $x;
                $tasks[$x]['procedure name'] = 'task_'.$x;

            } // while

        $code .= '////////////////////////////////////////////////////////////////////////////////////////////////////// P R O C E D U R E S //'."\n";

        $code .= "\n";
        $code .= "\n";
        $code .= "\n";

        $code .= '// C O N F I G S ////////////////////////////////////////////////////////////////////////////////////////////////////////////'."\n";
        $code .= '    $handlers = array();'."\n";
        $code .= "\n";
        $code .= '    $handlers[\'install\'] = \'task_install\';'."\n";
        $code .= '    $handlers[\'upgrade\'] = \'task_upgrade\';'."\n";
        $code .= "\n";
        foreach ($tasks AS $task => $data) {

            $procedure_name = $data['procedure name'];

            $code .= '    $handlers['.var_export($task,TRUE).'] = '.var_export($procedure_name,TRUE).';' ."\n";

        } // foreach
        $code .= "\n";
        $code .= '//////////////////////////////////////////////////////////////////////////////////////////////////////////// C O N F I G S //'."\n";
        $code .= "\n\n";
        $code .= '
//
// M A I N
//

    //
    // Figure out the task the user wants to invoke.
    //
        if (  2 > count($argv) || !in_array($argv[1], array_keys($handlers))  ) {
            // Error.
            task_help();
/////////// EXIT
            exit(1);
        }

        $task_name = $argv[1];

        if (  !isset($handlers[$task_name]) || !is_string($handlers[$task_name]) || \'\' == trim($handlers[$task_name]) || !function_exists($handlers[$task_name])  ) {
            task_help();
/////////// EXIT
            exit(1);
        }

        $procedure = $handlers[$task_name];

        $args = array_slice($argv, 2);

    //
    // Call the handler for the task.
    //
        call_user_func($procedure, $args);

';

    //
    // Output code.
    //
        print($code);
