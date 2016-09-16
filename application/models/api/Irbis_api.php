<?php

require_once 'Irbis_exception.php';

class Irbis_api extends CI_Model
{
    private
        $server_ip = '192.168.0.103',
        $server_port = 6666,
        $client_id = 12365789,
        $username = 1,
        $password = 1,
        $client_type = 'C',
        $database = 'RDR';

    private $query_number = 1;

    private $irbis_errors = array(
        0 => "ZERO",
        -1111 => "SERVER_EXECUTE_ERROR",
        -2222 => "WRONG_PROTOCOL",
        -3333 => "CLIENT_NOT_IN_LIST",
        -3334 => "CLIENT_NOT_IN_USE",
        -3335 => "CLIENT_IDENTIFIER_WRONG",
        -3336 => "CLIENT_NOT_ALLOWED",
        -3337 => "CLIENT_ALREADY_EXISTS",
        -4444 => "WRONG_PASSWORD",
        -5555 => "FILE_NOT_EXISTS",
        -6666 => "SERVER_OVERLOAD",
        -7777 => "PROCESS_ERROR",
        -100 => "READ_WRONG_MFN",
        -600 => "REC_DELETE",
        -601 => "REC_PHYS_DELETE",
        -602 => "ERR_RECLOCKED",
        -603 => "REC_DELETE",
        -607 => "AUTOIN_ERROR",
        -300 => "ERR_DBEWLOCK",
        -400 => "ERR_FILEMASTER",
        -401 => "ERR_FILEINVERT",
        -402 => "ERR_WRITE",
        -403 => "ERR_ACTUAL",
        -203 => "TERM_LAST_IN_LIST",
        -204 => "TERM_FIRST_IN_LIST",
        -202 => "TERM_NOT_EXISTS"
    );

    private $allowed_irbis_errors = array(0, -202, -3335, -3337);

    private $ini_file;

    public function open_connection()
    {
        $command = "A";

        $query = $command . "\n" .
            $this->client_type . "\n" .
            $command . "\n" .
            $this->client_id . "\n" .
            $this->query_number .
            "\n\n\n\n\n\n".
            $this->username . "\n" .
            $this->password . "\n";

        $this->query_number++;

        $this->ini_file = $this->execute_query($query);

        return TRUE;
    }

    public function close_connection()
    {
        $command = "B";

        $query = $command ."\n" .
            $this->client_type . "\n" .
            $command . "\n" .
            $this->client_id . "\n" .
            $this->query_number .
            "\n\n\n\n\n\n".
            $this->username . "\n" .
            $this->password;

        $this->execute_query($query);

        return TRUE;
    }

    public function get_ini_file()
    {
        return $this->ini_file;
    }

    public function set_database($irbis_database)
    {
        $this->database = $irbis_database;
    }

    public function get_mfn_amount()
    {
        $command = "O";

        $query = $command."\n".
            $this->client_type."\n".
            $command."\n".
            $this->client_id."\n".
            $this->query_number."\n".
            $this->username."\n".
            $this->password.
            "\n\n\n\n".
            $this->database."\n";

        $this->query_number++;

        $result = $this->execute_query($query);

        if($result[10] == -3335)
        {
            $this->login_client();

            $result = $this->execute_query($query);
        }

        return $result[10];
    }

    public function get_mfns($search_expression, $record_count = 0, $first_record = 1, $format = '@brief')
    {
        $command = "K";

        $query = $command."\n".
            $this->client_type."\n".
            $command."\n".
            $this->client_id."\n".
            $this->query_number."\n".
            $this->username."\n".
            $this->password."\n".
            "\n\n\n".
            $this->database."\n".
            $search_expression."\n".
            $record_count."\n".
            $first_record."\n".
            $format."\n";

        $this->query_number++;

        $result = $this->execute_query($query);

        if($result[10] == -3335)
        {
            $this->login_client();

            $result = $this->execute_query($query);
        }

        if(empty($format))
        {
            $mfn = array();

            $index = 12;

            while(isset($result[$index]) && !empty($result[$index]))
            {
                $mfn[] = $result[$index];

                $index++;
            }

            unset($result);

            $result = $mfn;
        }

        return $result;
    }

    public function get_record($mfn, $block = 0, $format = '@kn_h')
    {
        $command = "C";

        $query = $command."\n".
            $this->client_type."\n".
            $command."\n".
            $this->client_id."\n".
            $this->query_number."\n".
            $this->username."\n".
            $this->password."\n".
            "\n\n\n".
            $this->database."\n".
            $mfn."\n".
            $block."\n".
            $format."\n";

        $this->query_number++;

        $result = $this->execute_query($query, ($format !== '@kn_h') ? TRUE : FALSE);

        if($result[10] == -3335)
        {
            $this->login_client();

            $result = $this->execute_query($query);
        }

        if(empty($format))
        {
            $record = array();

            $record['mfn'] = substr(trim($result[11]), 0, -1);
            $record['version'] = substr(trim($result[12]), 2);

            $index = 13;

            while(isset($result[$index]) && !empty($result[$index]))
            {
                $result[$index] = trim($result[$index]);

                $division = strpos($result[$index], '#');

                $split_field_by_number = array(
                    mb_substr($result[$index], 0, $division),
                    mb_substr($result[$index], $division)
                );

                $split_field_by_letter = explode('^', $split_field_by_number[1]);

                $sub_fields = array();

                if(count($split_field_by_letter) != 1)
                {
                    foreach($split_field_by_letter as $sfl)
                    {
                        $sub_field_letter = mb_substr($sfl, 0, 1);

                        $sub_fields[$sub_field_letter] = mb_substr($sfl, 1);

                        if(empty($sub_fields[$sub_field_letter]))
                        {
                            unset($sub_fields[$sub_field_letter]);
                        }
                    }
                }
                else
                {
                    $sub_fields = mb_substr($split_field_by_letter[0], 1);
                }

                $field_number = $split_field_by_number[0];

                if(isset($record[$field_number]))
                {
                    if(isset($record[$field_number][0]) &&
                        is_array($record[$field_number][0]))
                    {
                        $record[$field_number][] = $sub_fields;
                    }
                    else
                    {
                        $temp = $record[$field_number];

                        unset($record[$field_number]);

                        $record[$field_number][] = $temp;
                        $record[$field_number][] = $sub_fields;
                    }
                }
                else
                {
                    $record[$field_number] = $sub_fields;
                }

                unset($sub_fields);

                $index++;
            }

            unset($result);

            $result = $record;
        }

        return $result;
    }

    public function get_ref_list($term, $num = 1000, $format = '')
    {
        $command = "H";

        $query = $command . "\n" .
            $this->client_type . "\n" .
            $command . "\n" .
            $this->client_id . "\n" .
            $this->query_number . "\n" .
            "\n\n\n\n\n" .
            $this->database . "\n" .
            $term . "\n".
            $num . "\n".
            $format . "\n";

        $this->query_number++;

        $result = $this->execute_query($query);

        if($result[10] == -3335)
        {
            $this->login_client();

            $result = $this->execute_query($query);
        }

        return $result;
    }

    public function get_ref_list_for_term($term, $num_posting = 0, $first_record = 1, $format = "@brief")
    {
        $command = "I";

        $query = $command."\n" .
            $this->client_type."\n" .
            $command."\n".
            $this->client_id."\n".
            $this->query_number. "\n".
            $this->username."\n".
            $this->password.
            "\n\n\n\n".
            $this->database."\n".
            $num_posting."\n".
            $first_record."\n".
            $format."\n".
            $term."\n";

        $this->query_number++;

        $result = $this->execute_query($query);

        if($result[10] == -3335)
        {
            $this->login_client();

            $result = $this->execute_query($query);
        }

        return $result;
    }

    public function get_file($file_name, $code = 10, $db_name = 'IBIS')
    {
        $command = "L";

        $query = $command."\n".
            $this->client_type."\n".
            $command."\n".
            $this->client_id."\n".
            $this->query_number."\n".
            "\n\n\n\n\n".
            $code.'.'.$db_name.'.'.$file_name."\n";

        $this->query_number++;

        $result = $this->execute_query($query);

        if($result[10] == -3335)
        {
            $this->login_client();

            $result = $this->execute_query($query);
        }

        return $result[10];
    }

    public function set_record(array $record, $update = 1, $lock = 0)
    {
        $command = "D";

        $string_data = $record[0].chr(31).chr(30);

        for($index = 1, $count = count($record); $index < $count; $index++)
        {
            $string_data .= $record[$index].chr(30).chr(31);
        }

        $query = $command."\n".
            $this->client_type."\n".
            $command."\n".
            $this->client_id."\n".
            $this->query_number."\n".
            $this->username."\n".
            $this->password."\n\n\n\n".
            $this->database."\n".
            $lock."\n".
            $update."\n".
            $string_data."\n";

        $this->query_number++;

        $result = $this->execute_query($query);

        if($result[10] == -3335)
        {
            $this->login_client();

            $result = $this->execute_query($query);
        }

        return ($result[10] >= 0) ? TRUE : FALSE;
    }

    private function login_client()
    {
        $command = "A";

        $query = $command . "\n" .
            $this->client_type . "\n" .
            $command . "\n" .
            $this->client_id . "\n" .
            $this->query_number .
            "\n\n\n\n\n\n".
            $this->username . "\n" .
            $this->password . "\n";

        $this->query_number++;

        $this->execute_query($query);
    }

    private function execute_query($query, $array_result = TRUE)
    {
        if (!($socket = socket_create(AF_INET, SOCK_STREAM, 0)))
        {
            $this->throw_irbis_exception(socket_last_error(), 'socket');
        }

        socket_set_option($socket, SOL_SOCKET, SO_SNDTIMEO, array('sec' => 5, 'usec' => 0));
        socket_set_option($socket, SOL_SOCKET, SO_RCVTIMEO, array('sec' => 3, 'usec' => 0));

        if (!($connect_result = @socket_connect($socket, $this->server_ip, $this->server_port)))
        {
            $this->throw_irbis_exception('', 'connection');
        }

        $query = sprintf("%d\n" . $query, strlen($query));

        socket_write($socket, $query, strlen($query));

        $response = '';

//        while($out = socket_read($socket, 2048))
//        {
//            $response .= $out;
//        }

        $attempts_to_execute = 5;

        do
        {
            while($out = socket_read($socket, 2048))
            {
                $response .= $out;
            }

            $attempts_to_execute--;
        }
        while (empty($response) || $attempts_to_execute != 0);

        $result = explode("\n", $response);

        if(is_numeric($result[10]) && $result[10] < 0 && !in_array($result[10], $this->allowed_irbis_errors))
        {
            $this->throw_irbis_exception($result[10], 'irbis');
        }

        socket_close($socket);

        return $array_result ? $result : $response;
    }

    private function throw_irbis_exception($error_code, $error_type = NULL)
    {
        switch($error_type)
        {
            case 'socket':
                $message = 'Socket error: '.socket_strerror($error_code);

                break;
            case 'connection':
                $message = 'Connection error: Remote server ('.$this->server_ip.':'.$this->server_port.') is unreachable';

                break;
            case 'irbis':
                $message = 'Irbis server error: '.(isset($this->irbis_errors[intval($error_code)])
                        ? $this->irbis_errors[intval($error_code)] : 'undefined error');

                break;
            default:
                $message = 'No message for occurred error';
        }

        throw new Irbis_exception($message);
    }
}