<?php

namespace SuperbHelperPro\Notices;

if (! defined('WPINC')) {
    die;
}

class NoticeData
{
    public static function GetData()
    {
        return self::$NOTICE_DATA;
    }

    private static $NOTICE_DATA = array(
        array(
            "Identity" => "elementor-notice",
            "Title" => "SuperbThemes + Elementor Page Builder = &#9825;",
            "Description" => "We recommend that you install the Elementor Page Builder plugin for even more customization options, such as the Drag & Drop Editor. No coding required!",
            "Buttons" => array(
                array(
                    "Title" => "Install Elementor",
                ),
                array(
                    "Title" => "Read More",
                )
            ),
            "CSS" => "div#screen-meta-links ~ div#spbhlprpro-notice-notice { margin:50px 0 20px; } .spbhlprpro-notice-notice { box-sizing: border-box; width: 100%; padding: 20px; background: white; box-shadow: 0 2px 4px rgba(20, 40, 80, 0.2); border-radius: 3px; font-size: 15px; line-height: 1.5; transform: translate3d(0, 0, 0); margin: 20px 0 20px; width:100%; width: -webkit-calc(100% - 20px); width: -moz-calc(100% - 20px); width: calc(100% - 20px); } .spbhlprpro-notice-message { align-items:center; } @keyframes superb-notice-fadein { 0% { transform: translate3d(0, 128px, 0); opacity: 0; } 100% { transform: translate3d(0, 0, 0); opacity: 100; } } .spbhlprpro-notice-message > p { margin: 0; padding: 0; width: 100%; font-size: 16px; color: #424242; max-width: 870px; } .spbhlprpro-notice-message > p:before { content: ' '; display: block; background: url(https://ps.w.org/elementor/assets/icon-256x256.png); height: 75px; width: 75px; background-size: 100%; float: left; margin: 0px 20px 10px 0px; } .spbhlprpro-notice-message > p span { display: block; font-weight: bold; font-size: 19px; } .spbhlprpro-notice-message a, .spbhlprpro-notice-message button { background: #eee; margin: 20px 20px 0px 0; border: 0px; color: #333; padding: 11px 20px; text-align: center; outline: none; white-space: nowrap; border-radius: 3px; text-decoration: none; font-size: 13px; min-height: 42px; font-weight: 500; border: 2px solid #eee; line-height: 1; letter-spacing: 0; } .spbhlprpro-notice-message a:first-of-type { color: #fff; background:#65d49a; border:2px solid #65d49a; } .spbhlprpro-notice-message a:nth-of-type(2) { color: #65d49a; background:#fff; border:2px solid #65d49a; } .spbhlprpro-notice-message button:last-of-type { background: rgba(0,0,0,0); border: 0px; border-bottom: 1px solid #e0e0e0; border-radius:0px; width: auto; padding: 0px 0px 3px 0px; min-height:0; color: #c71f1f; margin-left:10px; } @media screen and (max-width: 985px) { .spbhlprpro-notice-message button:first-of-type { margin-right:30px; } .spbhlprpro-notice-message button:last-of-type { margin-left:0; } } @media screen and (max-width: 600px) { .spbhlprpro-notice-message a, .spbhlprpro-notice-message button { display: block; height: auto; min-height: 0; width: 100%; text-align: center; box-sizing: border-box; margin-left: auto !important; margin-right: auto; } .spbhlprpro-notice-message > p:before { margin:0px auto 20px auto; float:none; } }"
        ),
    
        array(
            "Identity" => "wprocket-notice",
            "Title" => "Speed up your loading time with WP Rocket",
            "Description" => "Improve your page speed and get a faster website in a few clicks. No coding required.",
            "Buttons" => array(
                array(
                    "Title" => "Install WP Rocket",
                ),
                array(
                    "Title" => "Read More",
                )
            ),
            "CSS" => "div#screen-meta-links ~ div#spbhlprpro-notice-notice { margin:50px 0 20px; } .spbhlprpro-notice-notice { box-sizing: border-box; width: 100%; padding: 20px; background:#F56640; font-size: 15px; line-height: 1.5; transform: translate3d(0, 0, 0); margin: 20px 0 20px; width:100%; width: -webkit-calc(100% - 20px); width: -moz-calc(100% - 20px); width: calc(100% - 20px); } .spbhlprpro-notice-message { align-items:center; } @keyframes spbhlprpro-notice-fadein { 0% { transform: translate3d(0, 128px, 0); opacity: 0; } 100% { transform: translate3d(0, 0, 0); opacity: 100; } } .spbhlprpro-notice-message > p { margin: 0; padding: 0; width: 100%; font-size: 16px; color: #000; max-width: 870px; } .spbhlprpro-notice-message > p:before { content: ' '; display: block; background: url(https://superbthemes.com/wp-content/uploads/2020/01/wprocket-logo-square-small.png); height: 75px; width: 75px; background-size: 100%; float: left; margin: 0px 20px 10px 0px; } .spbhlprpro-notice-message > p span { display: block; font-weight: bold; font-size: 19px; } .spbhlprpro-notice-message a, .spbhlprpro-notice-message button { background: rgba(0,0,0,0); margin: 20px 20px 0px 0; color: #000; padding: 11px 20px; text-align: center; outline: none; white-space: nowrap; border-radius: 3px; text-decoration: none; font-size: 13px; min-height: 42px; font-weight: 500; border: 2px solid #000; line-height: 1; letter-spacing: 0; } .spbhlprpro-notice-message a:first-of-type { color: #fff; background:#000; border:2px solid #000; } .spbhlprpro-notice-message a:nth-of-type(2) { color: #000; background:rgba(0,0,0,0); border:2px solid #000; } .spbhlprpro-notice-message button:last-of-type { background: rgba(0,0,0,0); border: 0px; border-bottom: 1px solid #000; border-radius:0px; width: auto; padding: 0px 0px 3px 0px; min-height:0; color: #000; margin-left:10px; opacity:0.6; } @media screen and (max-width: 985px) { .spbhlprpro-notice-message button:first-of-type { margin-right:30px; } .spbhlprpro-notice-message button:last-of-type { margin-left:0; } } @media screen and (max-width: 600px) { .spbhlprpro-notice-message a, .spbhlprpro-notice-message button { display: block; height: auto; min-height: 0; width: 100%; text-align: center; box-sizing: border-box; margin-left: auto !important; margin-right: auto; } .spbhlprpro-notice-message > p:before { margin:0px auto 20px auto; float:none; } }"
        ),
    
        array(
            "Identity" => "allinoneseo-notice",
            "Title" => "SEO Optimize your WordPress site With All in One SEO Pack",
            "Description" => "More than 2 million people use All in One SEO Pack to optimize their WordPress site for SEO. It’s easy and works out of the box for beginners!",
            "Buttons" => array(
                array(
                    "Title" => "Install All In One SEO Pack",
                ),
                array(
                    "Title" => "Read More",
                )
            ),
            "CSS" => "div#screen-meta-links ~ div#spbhlprpro-notice-notice { margin:50px 0 20px; } .spbhlprpro-notice-notice { box-sizing: border-box; width: 100%; padding: 20px; background: white; border: 1px solid #d6d6d6; font-size: 15px; line-height: 1.5; transform: translate3d(0, 0, 0); margin: 20px 0 20px; width:100%; width: -webkit-calc(100% - 20px); width: -moz-calc(100% - 20px); width: calc(100% - 20px); } .spbhlprpro-notice-message { align-items:center; } @keyframes superb-notice-fadein { 0% { transform: translate3d(0, 128px, 0); opacity: 0; } 100% { transform: translate3d(0, 0, 0); opacity: 100; } } .spbhlprpro-notice-message > p { margin: 0; padding: 0; width: 100%; font-size: 16px; color: #424242; max-width: 870px; } .spbhlprpro-notice-message > p:before { content: ' '; display: block; background: url(https://ps.w.org/all-in-one-seo-pack/assets/icon-128x128.png); height: 75px; width: 75px; background-size: 100%; float: left; margin: 0px 20px 10px 0px; } .spbhlprpro-notice-message > p span { display: block; font-weight: bold; font-size: 19px; } .spbhlprpro-notice-message a, .spbhlprpro-notice-message button { background: #eee; margin: 20px 20px 0px 0; border: 0px; color: #333; padding: 11px 20px; text-align: center; outline: none; white-space: nowrap; text-decoration: none; font-size: 13px; min-height: 42px; font-weight: 500; border: 2px solid #eee; line-height: 1; letter-spacing: 0; } .spbhlprpro-notice-message a:first-of-type { color: #fff; background:#4275F4; border:2px solid #4275F4; } .spbhlprpro-notice-message a:nth-of-type(2) { color: #4275F4; background:#fff; border:2px solid #4275F4; } .spbhlprpro-notice-message button:last-of-type { background: rgba(0,0,0,0); border: 0px; border-bottom: 1px solid #e0e0e0; width: auto; padding: 0px 0px 3px 0px; min-height:0; color: #c71f1f; margin-left:10px; } @media screen and (max-width: 985px) { .spbhlprpro-notice-message button:first-of-type { margin-right:30px; } .spbhlprpro-notice-message button:last-of-type { margin-left:0; } } @media screen and (max-width: 600px) { .spbhlprpro-notice-message a, .spbhlprpro-notice-message button { display: block; height: auto; min-height: 0; width: 100%; text-align: center; box-sizing: border-box; margin-left: auto !important; margin-right: auto; } .spbhlprpro-notice-message > p:before { margin:0px auto 20px auto; float:none; } }"
        ),
    
    
    
        array(
            "Identity" => "ithemessecurity-notice",
            "Title" => "Secure your website with iThemes Security",
            "Description" => "Secure your website and fix common WordPress security issues you may not know exist easily, by adding an extra layer of protection.",
            "Buttons" => array(
                array(
                    "Title" => "Install iThemes Security",
                ),
                array(
                    "Title" => "Read More",
                )
            ),
            "CSS" => "div#screen-meta-links ~ div#spbhlprpro-notice-notice { margin:50px 0 20px; } .spbhlprpro-notice-notice { box-sizing: border-box; width: 100%; padding: 20px; background:#0B1A23 url('https://superbthemes.com/wp-content/uploads/2020/09/ithemes-security-grid-background-img.png'); font-size: 15px; line-height: 1.5; transform: translate3d(0, 0, 0); background-position: center; background-size: 114px; margin: 20px 0 20px; width:100%; width: -webkit-calc(100% - 20px); width: -moz-calc(100% - 20px); width: calc(100% - 20px); } .spbhlprpro-notice-message { align-items:center; } @keyframes spbhlprpro-notice-fadein { 0% { transform: translate3d(0, 128px, 0); opacity: 0; } 100% { transform: translate3d(0, 0, 0); opacity: 100; } } .spbhlprpro-notice-message > p { margin: 0; padding: 0; width: 100%; font-size: 16px; color: #fff; max-width: 870px; } .spbhlprpro-notice-message > p:before { content: ' '; display: block; background: url(https://superbthemes.com/wp-content/uploads/2020/09/ithemes-security-icon.png); height: 75px; width: 75px; background-size: 100%; float: left; margin: 0px 20px 10px 0px; } .spbhlprpro-notice-message > p span { display: block; font-weight: bold; font-size: 19px; } .spbhlprpro-notice-message a, .spbhlprpro-notice-message button { background: rgba(0,0,0,0); margin: 20px 20px 0px 0; color: #fff; padding: 11px 20px; text-align: center; outline: none; white-space: nowrap; border-radius: 3px; text-decoration: none; font-size: 13px; min-height: 42px; font-weight: 500; border: 2px solid #fff; line-height: 1; letter-spacing: 0; } .spbhlprpro-notice-message a:first-of-type { color: #000; background:#FFCD08; border:2px solid #FFCD08; } .spbhlprpro-notice-message a:nth-of-type(2) { color: #fff; background:rgba(0,0,0,0); border:2px solid #fff; } .spbhlprpro-notice-message button:last-of-type { background: rgba(0,0,0,0); border: 0px; border-bottom: 1px solid #fff; border-radius:0px; width: auto; padding: 0px 0px 3px 0px; min-height:0; color: #fff; margin-left:10px; opacity:0.6; } @media screen and (max-width: 985px) { .spbhlprpro-notice-message button:first-of-type { margin-right:30px; } .spbhlprpro-notice-message button:last-of-type { margin-left:0; } } @media screen and (max-width: 600px) { .spbhlprpro-notice-message a, .spbhlprpro-notice-message button { display: block; height: auto; min-height: 0; width: 100%; text-align: center; box-sizing: border-box; margin-left: auto !important; margin-right: auto; } .spbhlprpro-notice-message > p:before { margin:0px auto 20px auto; float:none; } }"
        ),
    
    
        array(
            "Identity" => "updraftplus-notice",
            "Title" => "Backup your website for free!",
            "Description" => "Keep your website safe by downloading the most used backup, restore and clone plugins for WordPress!",
            "Buttons" => array(
                array(
                    "Title" => "Install UpdraftPlus",
                ),
                array(
                    "Title" => "Read More",
                )
            ),
            "CSS" => "div#screen-meta-links ~ div#spbhlprpro-notice-notice { margin:50px 0 20px; } .spbhlprpro-notice-notice { box-sizing: border-box; width: 100%; padding: 20px; background-color: #db6939!important; background-image: linear-gradient(180deg,#db6939 0%,rgba(150,18,69,.31) 100%)!important; font-size: 15px; line-height: 1.5; transform: translate3d(0, 0, 0); margin: 20px 0 20px; width:100%; width: -webkit-calc(100% - 20px); width: -moz-calc(100% - 20px); width: calc(100% - 20px); border-radius:10px; box-shadow:0px 0px 5px rgba(0,0,0,.2); } .spbhlprpro-notice-message { align-items:center; } @keyframes spbhlprpro-notice-fadein { 0% { transform: translate3d(0, 128px, 0); opacity: 0; } 100% { transform: translate3d(0, 0, 0); opacity: 100; } } .spbhlprpro-notice-message > p { margin: 0; padding: 0; width: 100%; font-size: 16px; color: #fff; max-width: 870px; } .spbhlprpro-notice-message > p:before { content: ' '; display: block; background: url(https://superbthemes.com/wp-content/uploads/2020/09/updraftplus.png); height: 75px; width: 75px; background-size: 100%; background-repeat: no-repeat; background-position: center; background-size: 70%; float: left; margin: 0px 20px 10px 0px; } .spbhlprpro-notice-message > p span { display: block; font-weight: bold; font-size: 19px; } .spbhlprpro-notice-message a, .spbhlprpro-notice-message button { background: rgba(0,0,0,0); margin: 20px 20px 0px 0; color: #fff; padding: 11px 20px; text-align: center; outline: none; white-space: nowrap; border-radius: 3px; text-decoration: none; font-size: 13px; min-height: 42px; font-weight: 500; border: 2px solid #fff; line-height: 1; letter-spacing: 0; } .spbhlprpro-notice-message a:first-of-type { color: #d76439; background:#fff; border:2px solid #fff; } .spbhlprpro-notice-message a:nth-of-type(2) { color: #fff; background:rgba(0,0,0,0); border:2px solid #fff; } .spbhlprpro-notice-message button:last-of-type { background: rgba(0,0,0,0); border: 0px; border-bottom: 1px solid #fff; border-radius:0px; width: auto; padding: 0px 0px 3px 0px; min-height:0; color: #fff; margin-left:10px; opacity:0.6; } @media screen and (max-width: 985px) { .spbhlprpro-notice-message button:first-of-type { margin-right:30px; } .spbhlprpro-notice-message button:last-of-type { margin-left:0; } } @media screen and (max-width: 600px) { .spbhlprpro-notice-message a, .spbhlprpro-notice-message button { display: block; height: auto; min-height: 0; width: 100%; text-align: center; box-sizing: border-box; margin-left: auto !important; margin-right: auto; } .spbhlprpro-notice-message > p:before { margin:0px auto 20px auto; float:none; } }"
        ),
    
    
        array(
            "Identity" => "assetcleanup-notice",
            "Title" => "Asset CleanUp: Page Speed Booster",
            "Description" => "Don’t just minify & combine CSS/JavaScript files ending up with large, bloated and slow loading pages: Strip the unnecessary code and get a faster website!",
            "Buttons" => array(
                array(
                    "Title" => "Install Asset CleanUp",
                ),
                array(
                    "Title" => "Read More",
                )
            ),
            "CSS" => "div#screen-meta-links ~ div#spbhlprpro-notice-notice { margin:50px 0 20px; } .spbhlprpro-notice-notice { box-sizing: border-box; width: 100%; padding: 20px; background:#294266; font-size: 15px; line-height: 1.5; transform: translate3d(0, 0, 0); margin: 20px 0 20px; width:100%; width: -webkit-calc(100% - 20px); width: -moz-calc(100% - 20px); width: calc(100% - 20px); border-radius: 8px; box-shadow: 0 4px 35px 0 rgba(195, 65, 2, 0.2); } .spbhlprpro-notice-message { align-items:center; } @keyframes spbhlprpro-notice-fadein { 0% { transform: translate3d(0, 128px, 0); opacity: 0; } 100% { transform: translate3d(0, 0, 0); opacity: 100; } } .spbhlprpro-notice-message > p { margin: 0; padding: 0; width: 100%; font-size: 16px; color: #fff; max-width: 870px; } .spbhlprpro-notice-message > p:before { content: ' '; display: block; background: url(https://superbthemes.com/wp-content/uploads/2020/09/assetcleanup-pro.png); height: 75px; width: 75px; background-repeat: no-repeat; background-position: center; float: left; background-size:100%; margin: 0px 20px 10px 0px; } .spbhlprpro-notice-message > p span { display: block; font-weight: bold; font-size: 19px; } .spbhlprpro-notice-message a, .spbhlprpro-notice-message button { color: #fff; font-weight:bold; background:rgba(0,0,0,0); border:2px solid #fff; margin: 20px 20px 0px 0; padding: 11px 20px; text-align: center; outline: none; white-space: nowrap; border-radius: 4px; text-decoration: none; font-size: 13px; min-height: 42px; font-weight: 500; border: 2px solid #ffe0d0; line-height: 1; letter-spacing: 0; } .spbhlprpro-notice-message a:first-of-type { color: #fff; background:#37BF91; font-weight:bold; border:2px solid #37BF91; } .spbhlprpro-notice-message a:nth-of-type(2) { color: #fff; font-weight:bold; background:rgba(0,0,0,0); border:2px solid #fff; } .spbhlprpro-notice-message button:last-of-type { background: rgba(0,0,0,0); border: 0px; border-bottom: 1px solid #fff; border-radius:0px; width: auto; opacity:0.5; padding: 0px 0px 3px 0px; min-height:0; color: #fff; margin-left:10px; } @media screen and (max-width: 985px) { .spbhlprpro-notice-message button:first-of-type { margin-right:30px; } .spbhlprpro-notice-message button:last-of-type { margin-left:0; } } @media screen and (max-width: 600px) { .spbhlprpro-notice-message a, .spbhlprpro-notice-message button { display: block; height: auto; min-height: 0; width: 100%; text-align: center; box-sizing: border-box; margin-left: auto !important; margin-right: auto; } .spbhlprpro-notice-message > p:before { margin:0px auto 20px auto; float:none; } }"
        ),
    
        array(
            "Identity" => "ninjaforms-notice",
            "Title" => "Drag & Drop WordPress Form Builder",
            "Description" => "You can build beautiful WordPress forms without being a developer or web designer. Use Ninja Forms to build professional forms in minutes, no code required!",
            "Buttons" => array(
                array(
                    "Title" => "Install Ninja Forms",
                ),
                array(
                    "Title" => "Read More",
                )
            ),
            "CSS" => "div#screen-meta-links ~ div#spbhlprpro-notice-notice { margin:50px 0 20px; } .spbhlprpro-notice-notice { box-sizing: border-box; width: 100%; padding: 20px; background-color: #ef4748 !important; font-size: 15px; line-height: 1.5; transform: translate3d(0, 0, 0); margin: 20px 0 20px; width:100%; width: -webkit-calc(100% - 20px); width: -moz-calc(100% - 20px); width: calc(100% - 20px); box-shadow: 0px 0px 10px 0px rgba(0,0,0,0.1); border-radius: 20; } .spbhlprpro-notice-message { align-items:center; } @keyframes spbhlprpro-notice-fadein { 0% { transform: translate3d(0, 128px, 0); opacity: 0; } 100% { transform: translate3d(0, 0, 0); opacity: 100; } } .spbhlprpro-notice-message > p { margin: 0; padding: 0; width: 100%; font-size: 16px; color: #fff; max-width: 870px; } .spbhlprpro-notice-message > p:before { content: ' '; display: block; background: url(https://superbthemes.com/wp-content/uploads/2020/09/ninjaforms-icon-256x256-1.png); height: 75px; width: 75px; background-repeat: no-repeat; background-position: center; float: left; background-size:100%; margin: 0px 20px 10px 0px; } .spbhlprpro-notice-message > p span { display: block; font-weight: bold; font-size: 19px; } .spbhlprpro-notice-message a, .spbhlprpro-notice-message button { background: rgba(0,0,0,0); margin: 20px 20px 0px 0; color: #f2f061; padding: 11px 20px; text-align: center; outline: none; white-space: nowrap; border-radius: 30px; text-decoration: none; font-size: 13px; min-height: 42px; font-weight: 500; border: 2px solid #f2f061; line-height: 1; letter-spacing: 0; } .spbhlprpro-notice-message a:first-of-type { color: #000; background:#f2f061; border:2px solid #f2f061; } .spbhlprpro-notice-message a:nth-of-type(2) { color: #f2f061; background:rgba(0,0,0,0); border:2px solid #f2f061; } .spbhlprpro-notice-message button:last-of-type { background: rgba(0,0,0,0); border: 0px; border-bottom: 1px solid #f2f061; border-radius:0px; width: auto; padding: 0px 0px 3px 0px; min-height:0; color: #f2f061; margin-left:10px; opacity:0.6; } @media screen and (max-width: 985px) { .spbhlprpro-notice-message button:first-of-type { margin-right:30px; } .spbhlprpro-notice-message button:last-of-type { margin-left:0; } } @media screen and (max-width: 600px) { .spbhlprpro-notice-message a, .spbhlprpro-notice-message button { display: block; height: auto; min-height: 0; width: 100%; text-align: center; box-sizing: border-box; margin-left: auto !important; margin-right: auto; } .spbhlprpro-notice-message > p:before { margin:0px auto 20px auto; float:none; } }"
        )
    );
}
