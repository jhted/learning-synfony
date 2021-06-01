<?PHP


namespace App\Format;

class JSON  extends BaseFormat implements FromStringInterface{
    public function convert()
    {
        return json_encode($this->data);
    }
    public function convertFromString($string)
    {
        return json_decode($string, true);
    }
}