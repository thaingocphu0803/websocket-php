<?php

class TemplateController
{

	public function handle_template()
	{
		$input = json_decode(file_get_contents('php://input'), true);
		$templateName = $input['template'];
		$templatePath = __DIR__ . "/../../public/page/$templateName.php";

		$lastModified = filemtime($templatePath);



		header("Last-Modified: " . gmdate("D, d M Y H:i:s", $lastModified) . " GMT");
		header("Cache-Control: no-cache");



		if(isset($_SERVER['HTTP_IF_MODIFIED_SINCE']) && strtotime($_SERVER['HTTP_IF_MODIFIED_SINCE']) >= $lastModified){
			
			http_response_code(304);
			exit;
		}

		ob_start();
		include $templatePath;
		$content = ob_get_clean();

		echo $content;
	}
}
