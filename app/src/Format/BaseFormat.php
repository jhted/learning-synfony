<?PHP


namespace App\format;

class JSON {
    private $data;
    public function __constracter($data)
    {
        $this->data = $data;
    }
    public function getData()
    {
        return $this->data;
    }
    public function setData($data)
    {
        $this->data = $data;
    }
}