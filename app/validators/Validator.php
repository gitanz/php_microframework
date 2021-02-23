<?php


namespace app\validators;


class Validator
{
    use Rules;

    private bool $valid;
    private array $errors = [];
    private array $relation_rules = [];

    public function __construct()
    {
    }

    public function validate(array $formData, array $validations)
    {
        $this->validateField($formData, $validations);

        if (count($this->relation_rules)) {
            $this->validateCrossFields($formData);
        }

        $this->setValidity();

    }

    private function validateField($formData, $validations)
    {
        $relatedFields = [];
        foreach ($validations as $field => $rules) {
            $this->ruleOut($field, $rules, $formData);
        }
        return $relatedFields;
    }

    private function validateCrossFields($formData)
    {
        foreach ($this->relation_rules as $field => $relations) {
            $this->ruleOutCross($field, $relations, $formData);
        }
    }

    private function ruleOut($field, $ruleList, $formData)
    {
        $errors = [];
        $test = $formData[$field];
        foreach ($ruleList as $ruleComposed) {
            $ruleParsed = explode(":", $ruleComposed);
            $rule = array_shift($ruleParsed);
            $arguments = $ruleParsed;
            if ($rule == 'relation') {
                $this->relation_rules[$field][] = $arguments;
                continue;
            }
            list($valid, $message) = $this->$rule($ruleList, $test, ...$arguments);
            if (!$valid) {
                $this->errors[$field][] = preg_replace('/:name/', $field, $message);
            }
        }
    }



    private function ruleOutCross($from, $relations, $formData)
    {
        $input = $formData[$from];
        foreach($relations as $relationTo){
            $to = array_shift($relationTo);
            $type = array_shift($relationTo);
            $relation = array_shift($relationTo);
            $relatedInput = $formData[$to];
            list($valid, $message) = $this->$relation($type, $input, $relatedInput);
            if (!$valid) {
                $this->errors[$from][] = preg_replace(["/:first/", "/:second/"], [$from, $to], $message);
            }
        }

    }

    public function setValidity()
    {
        $this->valid = false;
        if(!count($this->getErrors())){
            $this->valid = true;
        }
    }

    public function isValid()
    {
        return $this->valid;
    }

    public function getErrors(){
        return $this->errors;
    }

}