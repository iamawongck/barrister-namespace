<?
namespace Barrister;

class Contract {

    private $interfaces;
    private $structs;
    private $enums;
    private $meta;

    public function __construct($idlFile, BarristerJsonDecoder $jsonDecoder) {

        $this->interfaces = array();
        $this->structs    = array();
        $this->enums      = array();
        $this->meta       = array();

        if (file_exists($idlFile)) {
            $fh = fopen($idlFile, 'r');
            $data = fread($fh, filesize($idlFile));
            fclose($fh);

            $idl = $jsonDecoder->decode($data);
        }
        else {
            throw new \Exception("File not found: $idlFile");
        }

        foreach ($idl as $val) {
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

    public function validateInterface($name) {
        return array_key_exists($name, $this->interfaces);
    }

    public function validateStruct($name) {
        return array_key_exists($name, $this->structs);
    }

    public function validateEnum($name) {
        return array_key_exists($name, $this->enums);
    }

    public function validateMeta($name) {
        return array_key_exists($name, $this->meta);
    }
}
