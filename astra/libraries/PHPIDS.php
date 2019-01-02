<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PHPIDS
 *
 * @author anandakrishna
 */
require_once(ASTRAPATH . 'Astra.php');

class PHPIDS {

    public function __construct($db, $ip) {
        $this->run();
    }

	
	protected function encode_items(&$item, $key){
		$orig = $item;
		
		//$item = iconv("UTF-8", "ASCII//IGNORE", $item);
		$item = iconv("UTF-8", "ISO-8859-1//IGNORE", $item);
		
		
		if($orig !== $item){
			$item = preg_replace('/[^a-zA-Z0-9]/', '', $item);
			$item = str_replace("--","", $item);
		}
	}
	
    public function run() {
        if (file_exists(dirname(__FILE__) . '/plugins/IDS/Init.php')) {
            require_once(dirname(__FILE__) . '/plugins/IDS/Init.php');
            require_once(dirname(__FILE__) . '/plugins/IDS/Monitor.php');
        } else {
            return FALSE;
        }

        try {
            $request = array(
                //'REQUEST' => $_REQUEST,
                'GET' => $_GET,
                'POST' => $_POST,
            );

            if (defined('CZ_ALLOW_FOREIGN_CHARS') && CZ_ALLOW_FOREIGN_CHARS == TRUE) {
				array_walk_recursive($request, array($this, 'encode_items'));
			}

            $init = IDS_Init::init(ASTRAPATH . 'libraries/plugins/IDS/Config/Config.ini.php');
            $init->config['General']['base_path'] = ASTRAPATH . 'libraries/plugins/IDS/';
            $init->config['General']['use_base_path'] = true;
            $init->config['Caching']['caching'] = 'none';

            $db_params = ASTRA::$_db->get_custom_params();

            $default_exceptions = array(
                'REQUEST._pk_ref_3_913b',
                'COOKIE._pk_ref_3_913b',
                'REQUEST._lf',
                'REQUEST.comment',
                'POST.comment',
                'REQUEST.permalink_structure',
                'POST.permalink_structure',
                'REQUEST.selection',
                'POST.selection',
                'REQUEST.content',
                'POST.content',
                'REQUEST.__utmz',
                'COOKIE.__utmz',
                'REQUEST.s_pers',
                'COOKIE.s_pers',
                'REQUEST.user_pass',
                'POST.user_pass',
                'REQUEST.pass1',
                'POST.pass1',
                'REQUEST.pass2',
                'POST.pass2',
                'REQUEST.password',
                'POST.password',
                'GET.gclid',
                'GET.access_token',
                'POST.customize',
                'POST.post_data',
                'POST.mail.body',
                'POST.mail.subject',
                'POST.mail.sender',
                'POST.form',
                'POST.customized',
                'POST.partials',
                'GET.mc_id',
                'POST.shortcode',
                'POST.mail_2.body',
                'POST.mail_2.subject',
                'POST.enquiry',
                'POST.pwd',
                'POST.g-recaptcha-response',
                'POST.g-recaptcha-res',
            );


            $exceptionArray = array_merge($default_exceptions, $db_params['exception']);
            $htmlArray = $db_params['html'];

            if (!defined('CZ_JSON_EXCLUDE_ALL') || CZ_JSON_EXCLUDE_ALL === FALSE) {
                $jsonArray = $db_params['json'];
            } else {
                $jsonArray = array();

                foreach ($request as $array => $keys) {
                    foreach ($keys as $par) {
                        $jsonArray[] = "$array.$par";
                    }
                }
            }

            $ids = new IDS_Monitor($request, $init);
            $ids->setExceptions($exceptionArray);
            $ids->setHtml($htmlArray);
            $ids->setJson($jsonArray);
            echo_debug('IDS Initialized');
            $result = $ids->run();
            echo_debug('IDS has run');

            if (!$result->isEmpty()) {
                echo_debug('IDS found issues. Will do +1 now.');
                //Increment Hack Attempt Count
                ASTRA::$_db->log_hit(ASTRA::$_ip);
                echo_debug('Attack has been recorded');

                $str_tags = "";
                $dataArray = array();

                foreach ($result->getTags() as $tag)
                    $str_tags .= '|' . $tag;

                $iterator = $result->getIterator();

                $param = "";
                foreach ($iterator as $threat) {
                    $param .= "p=" . urlencode($threat->getName()) . "|v=" . urlencode($threat->getValue());
                    $param .= "|id=";

                    foreach ($threat->getFilters() as $filter) {
                        $param .= $filter->getId() . ",";
                    }
                    $param = rtrim($param, ',') . "#";
                }

                $dataArray['blocking'] = ((int) ASTRA::$_db->is_blocked(ASTRA::$_ip)) + 1;

                $param = rtrim($param, '#');
                $dataArray['i'] = $result->getImpact();
                $dataArray["tags"] = $str_tags;
                $dataArray['param'] = $param;

                require_once(ASTRAPATH . 'libraries/API_connect.php');
                $connect = new API_connect();
                $connect->send_request("ids", $dataArray);

                ASTRA::show_block_page();
            } else {
                echo_debug('IDS says all is okay');
            }
        } catch (Exception $e) {
            printf('An error occured: %s', $e->getMessage());
        }
    }

}
