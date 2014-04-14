<?php
namespace Ingesta\Utils;

/**
    UrlTemplate - partial implementation of RFC6570: URI Template
    http://tools.ietf.org/html/rfc6570
**/
class UrlTemplate
{
    const OPERANDS = '+#./;?&=,!@|';


    public function renderTemplate($urlTemplate, $data)
    {
        $url = $urlTemplate;

        if (preg_match_all('/(\{[^}]+\})/', $url, $matches)) {
            $matches = $matches[1];

            foreach ($matches as $rawToken) {
                $token = $this->parseToken($rawToken);

                if (!empty($token->varlist)) {
                    //echo "Token: "; print_r($token);
                    $value = $this->formatData($token, $data);
                    if (!is_null($value)) {
                        //echo "[$token->raw][$value]\n";
                        $raw = preg_quote($token->raw);
                        $url = preg_replace("/$raw/", $value, $url);
                    }
                }
            }
        }

        return $url;
    }


    protected function formatData($token, $data)
    {
        //echo 'Token: '; print_r($token);
        //echo 'Data: '; print_r($data);

        $dataStr = null;

        if (empty($token->op)) {
            $buffer = array();

            foreach ($token->varlist as $var) {
                if (!empty($data[$var->name])) {
                    $value = $data[$var->name];

                    // Check if there are any maxlengths
                    if (!empty($var->maxlen)) {
                        $value = substr($value, 0, $var->maxlen);
                    }

                    array_push($buffer, rawurlencode($value));
                }
            }

            if (count($buffer)) {
                $dataStr = implode($token->op, $buffer);
            }
        } elseif ($token->op === '?') {
            // Query string parameters

            $buffer  = array();
            $dataStr = '';

            foreach ($token->varlist as $var) {
                if (!empty($data[$var->name])) {
                    $name  = $var->name;
                    $value = $data[$var->name];

                    // Check if there are any maxlengths
                    if (!empty($var->maxlen)) {
                        $value = substr($value, 0, $var->maxlen);
                    }

                    array_push($buffer, $name . '=' . urlencode($value));
                }
            }

            if (count($buffer)) {
                $dataStr = '?' . implode('&', $buffer);
            }
        }

        return $dataStr;
    }


    protected function parseToken($rawToken)
    {
        $token = (object) array(
            'raw'     => $rawToken,
            'op'      => '',
            'varlist' => array()
        );

        // Check if first character is an operator
        $varStart = 1;
        $opChar = $rawToken[$varStart];
        if (strpos(self::OPERANDS, $opChar) !== false) {
            $token->op = $opChar;
            $varStart++;
        }

        $varList = substr($rawToken, $varStart, -1);
        //echo "VARLIST: $varList\n";

        $varListTokens = explode(',', $varList);
        //echo "varListTokens: "; print_r($varListTokens);

        $vars = array();
        foreach ($varListTokens as $varToken) {
            $var = (object)array(
                'name' => ''
            );

            $varDef = explode(':', $varToken);
            $var->name = $varDef[0];

            if (!empty($varDef[1])) {
                $var->maxlen = $varDef[1];
            }


            array_push($token->varlist, $var);
        }

        return $token;
    }
}
