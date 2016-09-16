<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 8/31/16
 * Time: 9:59 PM
 */

class Auth_data_generator
{
    private $numbers;
    private $big_letters;
    private $small_letters;

    private $russian_letters;
    private $english_letters;


    public function __construct()
    {
        $this->numbers = array(48, 49, 50, 51, 52, 53, 54, 55, 56, 57);
        $this->big_letters = array(65, 66, 67, 68, 69, 70, 71, 72, 73, 74, 75, 76, 77, 78, 79, 80, 81, 82, 83, 84, 85, 86, 87, 88, 89, 90);
        $this->small_letters = array(97, 98, 99, 100, 101, 102, 103, 104, 105, 106, 107, 108, 109, 110, 111, 112, 113, 114, 115, 116, 117, 118, 119, 120, 121, 122);

        $this->russian_letters = array('А', 'Б', 'В', 'Г', 'Д', 'Е', 'Ё', 'Ж', 'З', 'И', 'Й', 'К', 'Л', 'М', 'Н', 'О', 'П', 'Р', 'С', 'Т', 'У', 'Ф', 'Х', 'Ц', 'Ч', 'Ш', 'Щ', 'Ъ', 'Ы', 'Ь', 'Э', 'Ю', 'Я', 'а', 'б', 'в', 'г', 'д', 'е', 'ё', 'ж', 'з', 'и', 'й', 'к', 'л', 'м', 'н', 'о', 'п', 'р', 'с', 'т', 'у', 'ф', 'х', 'ц', 'ч', 'ш', 'щ', 'ъ', 'ы', 'ь', 'э', 'ю', 'я');
        $this->english_letters = array('A', 'B', 'V', 'G', 'D', 'E', 'E', 'Gh', 'Z', 'I', 'Y', 'K', 'L', 'M', 'N', 'O', 'P', 'R', 'S', 'T', 'U', 'F', 'H', 'C', 'Ch', 'Sh', 'Sch', 'Y', 'Y', 'Y', 'E', 'Yu', 'Ya', 'a', 'b', 'v', 'g', 'd', 'e', 'e', 'gh', 'z', 'i', 'y', 'k', 'l', 'm', 'n', 'o', 'p', 'r', 's', 't', 'u', 'f', 'h', 'c', 'ch', 'sh', 'sch', 'y', 'y', 'y', 'e', 'yu', 'ya');

        $this->str_rand = '';
        $this->str_rand_length = 4;
    }

    public function get_auth_data(&$students_data)
    {
        $students_data['username'] = str_replace($this->russian_letters, $this->english_letters, $students_data['first_name']);

//        $students_data['username'] .= $this->get_random_string();
    }

    private function get_random_string()
    {
        $random = '';

        for($char = 0; $char < $this->str_rand_length; $char++)
        {
            switch(rand(1, 3))
            {
                case 1:
                {
                    $random .= chr($this->big_letters[rand(0, 25)]);

                    break;
                }
                case 2:
                {
                    $random .= chr($this->small_letters[rand(0, 25)]);

                    break;
                }
                case 3:
                {
                    $random .= chr($this->numbers[rand(0, 9)]);

                    break;
                }
            }
        }

        return $random;
    }
}