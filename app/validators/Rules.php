<?php


namespace app\validators;

trait Rules
{
    private static array $messages = [
        'required' => ':name is required.',
        'numeric' => ':name should be numeric.',
        'integer' => ':name should be integer number.',
        'alpha' => ':name should be only in alphabetic characters.',
        'alpha_num' => ':name should be only in alpha-numeric characters.',
        'date' => ':name should be in format YYYY-mm-dd.',
        'min_length' => ':name should be at least of :length characters.',
        'max_length' => ':name should be at most of :length characters.',
        'min_date' => ':name should not be before :date.',
        'max_date' => ':name should not be after :date.',
        'min_value' => ':name should be at least of value :value.',
        'max_value' => ':name should be at most of value :value.',
        'date_compare_lt' => ':first should be less than :second',
        'numeric_compare_lt' => ':first should be less than :second',
        'date_compare_lte' => ':first should be less than or equal to :second',
        'numeric_compare_lte' => ':first should be less than or equal to :second',
        'date_compare_gt' => ':first should be greater than :second',
        'numeric_compare_gt' => ':first should be greater than :second',
        'date_compare_gte' => ':first should be greater than or equal to :second',
        'numeric_compare_gte' => ':first should be greater than or equal to :second',
        'date_compare_eq' => ':first should be equal to :second',
        'numeric_compare_eq' => ':first should be equal to :second',
        'text_compare_eq' => ':first should be equal to :second',
        'date_compare_neq' => ':first should not be equal :second',
        'numeric_compare_neq' => ':first should not be equal :second',
        'text_compare_neq' => ':first should not be equal :second'
    ];

    protected function required($allRules, $test)
    {
        $valid = strlen(trim($test)) > 0;
        $message = $valid ?: self::$messages['required'];
        return [ $valid, $message];
    }

    protected function numeric($allRules, $test)
    {
        $valid = is_numeric(trim($test));
        $message = $valid ?: self::$messages['numeric'];
        return [ $valid, $message];
    }

    protected function alpha($allRules, $test)
    {
        $valid = preg_match('/^[a-zA-Z_\-\s]*$/',trim($test));
        $message = $valid ?: self::$messages['alpha'];
        return [ $valid, $message];
    }

    protected function alpha_num($allRules, $test)
    {
        $valid = (bool)preg_match('/^[a-zA-Z0-9_\-\s]*$/',trim($test));
        $message = $valid ?: self::$messages['alpha_num'];
        return [ $valid, $message];
    }

    protected function date($allRules, $test)
    {
        $valid = (bool)preg_match('/^([12]\d{3}-(0[1-9]|1[0-2])-(0[1-9]|[12]\d|3[01]))$/',trim($test));
        $message = $valid ?: self::$messages['date'];
        return [ $valid, $message];
    }

    protected function integer($allRules, $test)
    {
        $valid = is_int(trim($test));
        $message = $valid ?: self::$messages['integer'];
        return [ $valid, $message];
    }

    protected function min($allRules, $test, $min)
    {
        $valid = true; $message = false;

        if(!in_array('numeric', $allRules) &&
           !in_array('date', $allRules))
        {
            $valid = strlen(trim($test)) >= $min;
            $message = $valid ?: str_replace(':length', $min, self::$messages['min_length']);
        }
        elseif(in_array('numeric', $allRules))
        {
            $valid = (int)$test >= $min;
            $message = $valid ?: str_replace(':value', $min, self::$messages['min_value']);
        }
        elseif(in_array('date', $allRules))
        {
            $valid = strtotime($test) >= strtotime($min);
            $message = $valid ?: str_replace(':date', $min, self::$messages['min_date']);
        }
        return [$valid, $message];
    }

    protected function max($allRules, $test, $max)
    {
        $valid = true; $message = false;

        if(!in_array('numeric', $allRules) &&
            !in_array('date', $allRules))
        {
            $valid = strlen(trim($test)) <= $max;
            $message = $valid ?: str_replace(':length', $max, self::$messages['max_length']);
        }
        elseif(in_array('numeric', $allRules))
        {
            $valid = (int)$test <= $max;
            $message = $valid ?: str_replace(':value', $max, self::$messages['max_value']);
        }
        elseif(in_array('date', $allRules))
        {
            $valid = strtotime($test) <= strtotime($max);
            $message = $valid ?: str_replace(':date', $max, self::$messages['max_date']);
        }
        return [$valid, $message];
    }

    protected function lt($type, $input, $compareTo)
    {
        switch ($type)
        {
            case 'date':
                $valid = strtotime($input) < strtotime($compareTo);
                $message = $valid ?: self::$messages['date_compare_lt'];
                break;

            case 'number':
            default:
                $valid = (float)$input < (float)$compareTo;
                $message = $valid ?: self::$messages['numeric_compare_lt'];
                break;

        }
        return [$valid, $message];
    }

    protected function lte($type, $input, $compareTo)
    {
        switch ($type)
        {
            case 'date':
                $valid = strtotime($input) <= strtotime($compareTo);
                $message = $valid ?: self::$messages['date_compare_lte'];
                break;

            case 'number':
            default:
                $valid = (float)$input <= (float)$compareTo;
                $message = $valid ?: self::$messages['numeric_compare_lte'];
                break;

        }
        return [$valid, $message];
    }


    protected function gt($type, $input, $compareTo)
    {
        switch ($type)
        {
            case 'date':
                $valid = strtotime($input) > strtotime($compareTo);
                $message = $valid ?: self::$messages['date_compare_gt'];
                break;

            case 'number':
            default:
                $valid = (float)$input > (float)$compareTo;
                $message = $valid ?: self::$messages['numeric_compare_gt'];
                break;

        }
        return [$valid, $message];
    }

    protected function gte($type, $input, $compareTo)
    {
        switch ($type)
        {
            case 'date':
                $valid = strtotime($input) >= strtotime($compareTo);
                $message = $valid ?: self::$messages['date_compare_gte'];
                break;

            case 'number':
            default:
                $valid = (float)$input >= (float)$compareTo;
                $message = $valid ?: self::$messages['numeric_compare_gte'];
                break;

        }
        return [$valid, $message];
    }

    protected function eq($type, $input, $compareTo)
    {
        switch ($type)
        {
            case 'date':
                $valid = strtotime($input) == strtotime($compareTo);
                $message = $valid ?: self::$messages['date_compare_eq'];
                break;

            case 'number':
                $valid = (float)$input == (float)$compareTo;
                $message = $valid ?: self::$messages['numeric_compare_eq'];
                break;

            default:
            case 'text':
                $valid = trim($input) == trim($compareTo);
                $message = $valid ?: self::$messages[':text_compare_eq'];
                break;

        }
        return [$valid, $message];
    }

    protected function neq($type, $input, $compareTo)
    {
        switch ($type)
        {
            case 'date':
                $valid = strtotime($input) != strtotime($compareTo);
                $message = $valid ?: self::$messages['date_compare_neq'];
                break;

            case 'number':
                $valid = (float)$input != (float)$compareTo;
                $message = $valid ?: self::$messages['numeric_compare_neq'];
                break;

            default:
            case 'text':
                $valid = trim($input) != trim($compareTo);
                $message = $valid ?: self::$messages[':text_compare_neq'];
                break;

        }
        return [$valid, $message];
    }

}