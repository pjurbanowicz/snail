<?php
namespace Table\Model;

class Table
{
    private $sizeROWS; //ilosc wierszy
    private $sizeCOLS; //ilosc kolumn
	private $tab; //glowna tabela
	private $snail=''; //ciag znakow slimaka

	public function __construct($sizeROWS,$sizeCOLS)
	{
		$this->sizeROWS=$sizeROWS;
		$this->sizeCOLS=$sizeCOLS;
	}
	
	private function generateString($length) //generuje stringa o $length dlugosci 
	{
		$characters='0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
		$result='';
		for ($i=0;$i<$length;$i++) $result.=$characters[rand(0,61)];
			
		return $result;
	}
	
	public function fill() //uzupelnia tabele losowymi znakami
	{
		for($i=0;$i<$this->sizeROWS;$i++) 
			for($j=0;$j<$this->sizeCOLS;$j++) 
				$this->tab[$i][$j]=$this->generateString(2);		
	}
	
	public function getValue($row,$col)
	{
		return $this->tab[$row][$col];
	}
	
	public function getTable()
	{
		return $this->tab;
	}
	
	
	public function update(&$postTable) //zaktualizuj tabele na podstawie przeslanej tabeli $_POST
	{
		for($i=0;$i<$this->sizeROWS;$i++) 
			for($j=0;$j<$this->sizeCOLS;$j++) 
				$this->tab[$i][$j]=$postTable[$i.'_'.$j]; //nazwa pol ma format WIERSZ_KOLUMNA
	}
	
	public function snail($offset=0)
	{
		//jezeli podwojny offset jest wiekszy od liczby kolumn lub wierszy przerwij rekurencje
		if($offset*2>=$this->sizeROWS||$offset*2>=$this->sizeCOLS) return;
	
		//przejdz przez gorna scianke slimaka od lewej do prawej
		for($j=0+$offset;$j<$this->sizeCOLS-$offset;$j++) $this->snail.=($this->tab[0+$offset][$j].', ');
		
		//przejdz przez prawa scianke slimaka od gory do dolu
		for($j=0+1+$offset;$j<$this->sizeROWS-$offset;$j++) $this->snail.=$this->tab[$j][$this->sizeCOLS-1-$offset].', ';
		
		//jezeli liczba pozostalych wierszy jest rowna 1 lub mniej nie wykonuj przejscia
		//przejdz przez dolna scianke slimaka od lewej do prawej
		if($this->sizeROWS-$offset*2>1) for($j=$this->sizeCOLS-1-1-$offset;$j>=0+$offset;$j--) $this->snail.=$this->tab[$this->sizeROWS-1-$offset][$j].', ';
		
		//jezeli liczba pozostalych kolumn jest rowna 1 lub mniej nie wykonuj przejscia
		//przejdz przez lewa scianke slimaka od dolu do gory
		if($this->sizeCOLS-$offset*2>1) for($j=$this->sizeROWS-1-1-$offset;$j>=0+1+$offset;$j--) $this->snail.=$this->tab[$j][0+$offset].', ';
			
		//wykonaj rekurencyjnie funkcje ze zwiekszonym offsetem(przesunieciem)
		$this->snail(++$offset);
	}
	
	public function getSnail() //pobiera ciag znakow slimaka
	{
		return $this->snail;
	}
}
?>