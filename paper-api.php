<?php
	/*
	* Fork from: https://github.com/astet-gag/MathCoin-php
	* GitHub: https://github.com/g00se/PaperGame-php
	* @author Astet (Andrew Galenko) and @g00se (Mikhail)
	* @version 1.0
	*/
	
	class PaperApi {
		private $url = "https://paper.12kot3k.ru/api.php";
		private $key = '';
		private $uid = '';

		public function __construct($uid,$key){
			$this->key = $key;
			$this->uid = $uid;
		}

		private function request($data){
			$data['token'] = $this->key;
			$ch = curl_init();
			curl_setopt_array($ch, [
				CURLOPT_URL => $this->url,
				CURLOPT_POST => true,
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_POSTFIELDS => json_encode($data,JSON_UNESCAPED_UNICODE)
			]);
			$response = curl_exec($ch);
			$code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			curl_close($ch);
			return json_decode($response,true);
		}

		public function score($id){
			return $this->request([
				'method' => 'score',
				'id' => $id
			])['score'];
		}

		public function send($toId,$sum){
			return $this->request([
				'method' => 'send_score',
				'to' => $toId,
				'amount' => $sum
			])['success'];
		}

		public function txList($ltx){
			return $this->request([
				'method' => 'tx_list',
				'lastTx' => $ltx
			])['tx_list'];
		}

		public function txLink($sum){
			return 'https://m.vk.com/app7361871#t'.$this->uid.'_'.$sum;
		}
	}
?>
