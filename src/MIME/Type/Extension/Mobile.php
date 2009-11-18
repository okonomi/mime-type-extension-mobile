<?php

require_once 'MIME/Type/Extension.php';


class MIME_Type_Extension_Mobile extends MIME_Type_Extension
{
    public $extensionToType = array(
        'vbm'  => 'text/x-vbookmark',                // vBookmark
        'vcf'  => 'text/x-vcard',                    // vCard
        'vcs'  => 'text/x-vcalendar',                // vCalendar
        'vmg'  => 'text/x-vmessage',                 // vMessage
        'vnt'  => 'text/x-vnote',                    // vNote

        '3gp'  => array('audio' => 'audio/3gpp',  'video' => 'video/3gpp'),
        '3g2'  => array('audio' => 'audio/3gpp2', 'video' => 'video/3gpp2'),
        'mp4'  => array('audio' => 'audio/mp4',   'video' => 'video/mp4'),

        'afd'  => 'application/x-avatar',            // キャラ電
        'cfd'  => 'application/x-character-overlay', // マチキャラ
        'dmt'  => 'application/x-decomail-template', // デコメールテンプレート
        'vgt'  => 'application/x-dcm-vgt'            // デコメアニメテンプレート
        'ifm'  => 'image/gif',                       // 写真フレーム
        'jam'  => 'application/x-jam',               // iアプリ
        'mld'  => 'application/x-mld',               // 着信メロディ
        'mmd'  => 'application/x-character-overlay', // マチキャラメタデータ
        'trc'  => 'application/x-toruca',            // トルカ
        'ucm'  => 'application/x-ucf-package',       // きせかえツール

        'hdml' => 'text/x-hdml',                     // HDML
        'qcp'  => 'audio/vnd.qcelp',                 // QCP
        'pmd'  => 'application/x-pmd',               // C-MIDI
        'mmf'  => 'application/x-smaf',              // SMAF
        'amc'  => 'application/x-mpeg',              // AMC
        'kjx'  => 'application/x-kjx',               // EZアプリ(Java)
        'khm'  => 'application/x-kddi-htmlmail',     // デコレーションメールテンプレート

        'mml'  => 'text/x-mml',
        'jad'  => 'text/vnd.sun.j2me.app-descriptor',
        'smd'  => 'audio/x-smd',

        'dd'   => 'application/vnd.oma.dd+xml',
        'dcf'  => 'application/vnd.oma.drm.content',
        'dm'   => 'application/vnd.oma.drm.message',
    );

    function __construct()
    {
        $vars = get_class_vars('MIME_Type_Extension');

        $this->extensionToType = array_merge($vars['extensionToType'], $this->extensionToType);
    }

    public function addMIMEType($extension, $mimetype)
    {
        $this->extensionToType[$extension] = $mimetype;

        return $this;
    }

    public function addMIMETypes(array $mimetypes)
    {
        $this->extensionToType = array_merge($mimetypes, $this->extensionToType);

        return $this;
    }

    public function getMIMEType($file)
    {
        $extension = substr(strrchr($file, '.'), 1);
        if ($extension === false) {
            return PEAR::raiseError("File has no extension.");
        }

        if (!isset($this->extensionToType[$extension])) {
            return PEAR::raiseError("Sorry, couldn't determine file type.");
        }

        $ret = $this->extensionToType[$extension];
        if (in_array($extension, array('3gp', '3g2', 'mp4'))) {
            if (is_readable($file)) {
                if ($this->is3GPPVideo($file)) {
                    $ret = $ret['video'];
                } else {
                    $ret = $ret['audio'];
                }
            }
        }

        return $ret;
    }

    protected function is3GPPVideo($file)
    {
        $data = file_get_contents($file);
        return strpos($data, 'vide') !== false;
    }
}
