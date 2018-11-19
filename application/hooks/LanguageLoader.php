<?php
class LanguageLoader
{
    function initialize() 
    {
        $ci =& get_instance();
        $ci->load->helper('language');

        $site_lang = $ci->session->userdata('site_lang');
        
        if ($site_lang) 
        {
            if($site_lang == 'eng') { $ci->session->set_userdata('site_lang_id','1'); }
            if($site_lang == 'esp') { $ci->session->set_userdata('site_lang_id','2'); }
            
            $ci->lang->load('form',$ci->session->userdata('site_lang'));
            $ci->lang->load('menu',$ci->session->userdata('site_lang'));
            $ci->lang->load('pagedata',$ci->session->userdata('site_lang'));
        } 
        else 
        {
            $ci->lang->load('form','eng');
            $ci->lang->load('menu','eng');
            $ci->lang->load('pagedata','eng');
            $ci->session->set_userdata('site_lang','eng');
            $ci->session->set_userdata('site_lang_id','1');
            $ci->session->set_userdata('site_coin','$');
            $ci->session->set_userdata('site_coin_id','1');
        }

        $ci->session->set_userdata('site_coin','$');
        $ci->session->set_userdata('site_coin_id','1');
        
        $ci->form_validation->set_message('isNotUniqueMail', $ci->lang->line('auth_error_emailnotexist'));
        $ci->form_validation->set_message('isUniqueMail', $ci->lang->line('auth_error_emailexist'));
        $ci->form_validation->set_message('isConfirmed', $ci->lang->line('auth_error_emailnotconfirm'));

        
    }
}