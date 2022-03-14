<?php
namespace Store\Model;

use Generic\Model\AbstractModel;

class Customer extends AbstractModel
{
    public int $IDN;
    public String $name;
    public String $password;
    public String $email;
    
    public function exchangeArray($data)
    {
        $this->IDN = ($data['IDN'] ?? 0);
        $this->name = ($data['name'] ?? '');
        $this->password = $this->encrypt(($data['password'] ?? ''));
        $this->email = ($data['email'] ?? '');
    }
    
    protected function encrypt(String $text)
    {
        $text = strrev(hash('md5', $text));
        $subtext = substr($text,1,rand(0,strlen($text)-1));
        $text = substr($subtext . $text, 0, strlen($text));
        return hash('sha256', $text);
    }
}