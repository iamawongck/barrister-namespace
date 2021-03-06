<?php

namespace Barrister;

class BarristerContract {
    /**
     * @var BarristerInterface[]
     */
    public $interfaces;

    public $idl;

    /**
     * @var array
     */
    public $structs;

    /**
     * @var array
     */
    public $enums;

    /**
     * @var array
     */
    public $meta;

    /**
     * @param \stdClass $idl json_decoded idl file
     */
    public function __construct($idl) {
        $this->idl        = $idl;
        $this->interfaces = array();
        $this->structs    = array();
        $this->enums      = array();
        $this->meta       = array();

        foreach ($idl as $i => $val) {
            $type = $val->type;
            if ($type === "interface") {
                $this->interfaces[$val->name] = new BarristerInterface($val);
            }
            elseif ($type === "struct") {
                $this->structs[$val->name] = $val;
            }
            elseif ($type === "enum") {
                $this->enums[$val->name] = $val;
            }
            elseif ($type === "meta") {
                foreach ($val as $k => $v) {
                    if ($k !== "type") {
                        $this->meta[$k] = $v;
                    }
                }
            }
        }
    }

    /**
     * @return array
     */
    public function getMeta() {
        return $this->meta;
    }

    /**
     * @param string $name
     * @return BarristerInterface
     */
    public function getInterface($name) {
        return $this->interfaces[$name];
    }

    /**
     * @param string $interfaceName
     * @throws \Exception
     */
    public function checkInterface($interfaceName) {
        $iface = $this->getInterface($interfaceName);
        if (!$iface) {
            throw new \Exception("No interface found with name: $interfaceName");
        }
    }

    /**
     * @param string          $name
     * @param \stdClass       $expected json_decoded object that consists of 'optional', 'type'
     * @param bool            $isArray
     * @param string|int|bool $val
     * @return null|string
     */
    public function validate($name, $expected, $isArray, $val) {
        if ($val === null) {
            if ($expected->optional === true) {
                return null;
            }
            else {
                return "$name cannot be null";
            }
        }
        else {
            if ($isArray) {
                if (is_array($val)) {
                    $len = count($val);
                    for ($i = 0; $i < $len; $i++) {
                        $invalid = $this->validate($name . "[$i]", $expected, false, $val[$i]);
                        if ($invalid !== null) {
                            return $invalid;
                        }
                    }

                    return null;
                }
                else {
                    return $this->typeErr($name, "[]" . $expected->type, $val);
                }
            }
            elseif ($expected->type === "string") {
                if (is_string($val)) {
                    return null;
                }
                else {
                    return $this->typeErr($name, "string", $val);
                }
            }
            elseif ($expected->type === "bool") {
                if (is_bool($val)) {
                    return null;
                }
                else {
                    return $this->typeErr($name, "bool", $val);
                }
            }
            elseif ($expected->type === "int") {
                if (is_int($val)) {
                    return null;
                }
                else {
                    return $this->typeErr($name, "int", $val);
                }

            }
            elseif ($expected->type === "float") {
                if (is_int($val) || is_float($val)) {
                    return null;
                }
                else {
                    return $this->typeErr($name, "float", $val);
                }
            }
            else {
                if (isset($this->enums[$expected->type])) {
                    $enum = $this->enums[$expected->type];
                    if ($enum) {
                        if (!is_string($val)) {
                            return "$name - enum values must be strings, got: " . gettype($val);
                        }

                        $len = count($enum->values);
                        for ($i = 0; $i < $len; $i++) {
                            if ($enum->values[$i]->value === $val) {
                                return null;
                            }
                        }

                        return "$name value '$val' is not in the enum '" . $enum->name . "'";
                    }
                }

                if (isset($this->structs[$expected->type])) {
                    $struct = $this->structs[$expected->type];
                    if ($struct) {
                        if (is_array($val) || is_object($val)) {
                            $fields = $this->getAllStructFields(array(), $struct);
                            $vars   = $val;
                            if (is_object($val)) {
                                $vars = get_object_vars($val);
                            }

                            $validFields = array();
                            foreach ($fields as $i => $f) {
                                if (array_key_exists($f->name, $vars)) {
                                    $invalid = $this->validate($name . "." . $f->name, $f, $f->is_array, $vars[$f->name]);
                                    if ($invalid !== null) {
                                        return $invalid;
                                    }
                                }
                                else if (!$f->optional) {
                                    return "$name missing required field '" . $f->name . "'";
                                }

                                $validFields[$f->name] = 1;
                            }

                            foreach ($vars as $k => $v) {
                                if (!array_key_exists($k, $validFields)) {
                                    return "$name contains invalid field '$k' for type '" . $f->name . "'";
                                }
                            }

                            return null;
                        }
                        else {
                            return $this->typeErr($name, $expected->type, $val);
                        }
                    }
                }

                return "$name - Unknown type: " . $expected->type;
            }
        }
    }

    private function getAllStructFields($arr, $struct) {
        foreach ($struct->fields as $i => $f) {
            array_push($arr, $f);
        }

        if ($struct->extends) {
            $parent = $this->structs[$struct->extends];
            if ($parent) {
                return $this->getAllStructFields($arr, $parent);
            }
        }

        return $arr;
    }

    private function typeErr($name, $expType, $val) {
        $actual = gettype($val);
        $s      = "$name expects type '$expType' but got type '$actual'";
        if ($actual !== "object") {
            $s .= " for value: $val";
        }
        return $s;
    }
}