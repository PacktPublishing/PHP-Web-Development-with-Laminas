<?php
namespace Inventory\Model;

use Generic\Model\AbstractModel;

class Employee extends AbstractModel
{
    public int $ID;
    public String $name;
    public String $nickname;    
    public String $password;
    
    public function exchangeArray($data)
    {
        $this->ID = ($data['ID'] ?? 0);
        $this->name = ($data['name'] ?? '');
        $this->nickname = ($data['nickname'] ?? '');        
        $this->password = $this->encrypt(($data['password'] ?? ''));
    }
    
    protected function encrypt(String $text)
    {
        $text = strrev(hash('sha256', $text));
        $subtext = substr($text,1,rand(0,strlen($text)-1));
        $text = substr($subtext . $text, 0, strlen($text));
        return hash('md5', $text);
    }
}