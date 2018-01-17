<?php
require_once dirname(__FILE__) . '/../../../../core/php/core.inc.php';
class voletProp extends eqLogic {
    	public function execPropVolet($Hauteur) {
		$HauteurVolet=$this->getCmd(null,'hauteur')->execCmd();
		if($HauteurVolet > $Hauteur){
			$cmd=cmd::byId($this->getConfiguration('cmdDown'));
			if(is_object($cmd))
				$cmd->event();
			$Delta=$HauteurVolet-$Hauteur;
			log::add('voletProp','debug',$this->getHumanName().' Nous allons descendre le volet de '.$Delta.'%');
		}else{
			$cmd=cmd::byId($this->getConfiguration('cmdUp'));
			if(is_object($cmd))
				$cmd->event();
			$Delta=$Hauteur-$HauteurVolet;
			log::add('voletProp','debug',$this->getHumanName().' Nous allons monter le volet de '.$Delta.'%');
		}
		sleep($this->TpsAction($Delta));
		$cmd=cmd::byId($this->getConfiguration('cmdStop'));
		if(is_object($cmd))
			$cmd->event();
		
		log::add('voletProp','debug',$this->getHumanName().' Le volet est a '.$Hauteur.'%');
		$this->checkAndUpdateCmd('hauteur',$Hauteur);
	}
    	public function TpsAction($Hauteur) {
		$tps=$this->getConfiguration('Ttotal')*$Hauteur/100;
		log::add('voletProp','debug',$this->getHumanName().' Temps d\'action '.$tps.'s');
		return $tps;
	}
	public function AddCommande($Name,$_logicalId,$Type="info", $SubType='binary',$visible,$Value=null,$Template='') {
		$Commande = $this->getCmd(null,$_logicalId);
		if (!is_object($Commande))
		{
			$Commande = new voletPropCmd();
			$Commande->setId(null);
			$Commande->setName($Name);
			$Commande->setIsVisible($visible);
			$Commande->setLogicalId($_logicalId);
			$Commande->setEqLogic_id($this->getId());
		}
		if($Value!=null)
			$Commande->setValue($Value);
		$Commande->setType($Type);
		$Commande->setSubType($SubType);
   		$Commande->setTemplate('dashboard',$Template );
		$Commande->setTemplate('mobile', $Template);
		$Commande->save();
		return $Commande;
	}
	public function postSave() {
		$hauteur=$this->AddCommande("Hauteur","hauteur","info", 'numeric',true);
		$this->AddCommande("Position","position","action", 'slider',true,$hauteur->getId());
		$this->AddCommande("Up","up","action", 'other',true);
		$this->AddCommande("Down","down","action", 'other',true);
		$this->AddCommande("Stop","stop","action", 'other',true);
	}	
}
class voletPropCmd extends cmd {
    public function execute($_options = null) {
		switch($this->getLogicalId()){
			case "up":
				$cmd=cmd::byId($this->getEqLogic()->getConfiguration('cmdUp'));
				if(is_object($cmd))
					$cmd->event();
			break;
			case "down":
				$cmd=cmd::byId($this->getEqLogic()->getConfiguration('cmdDown'));
				if(is_object($cmd))
					$cmd->event();
			break;
			case "stop":
				$cmd=cmd::byId($this->getEqLogic()->getConfiguration('cmdStop'));
				if(is_object($cmd))
					$cmd->event();
			break;
			case "position":
				$this->getEqLogic()->execPropVolet($_options['slider']);
			break;
		}
	}
}
?>