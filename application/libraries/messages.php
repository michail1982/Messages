<?php
/**
 * Библиотека сообщений
 * @author Michail1982
 */
class Messages {
    /**
     * Массив сообщений
     * @var array
     */
    private $_messages = array();
    /**
     * Поддерживаемые типы сообщений
     * @var array ( тип сообщения  => шаблон вывода )
     */
    private $_message_wrapper = array(
            'success' => '<p class="message success">%s</p>',
            'info' => '<p class="message info">%s</p>',
            'error' => '<p class="message error">%s</p>'
    );

    /**
     * Шаблон вывода блока сообщений
     * @var string
     */
    private $_message_block_wrapper = '<p id="messages">%s</p>';

    /**
     * Флаг показа сообщений
     * @var boolean
     */
    private $_messages_showed = FALSE;

    /**
    * Constructor - Sets Preferences
    *
    * The constructor can be passed an array of config values
    */
    function __construct($config = array())
    {
        if ( ! empty($config))
        {
            $this->initialize($config);
        }
        $CI = & get_instance();

        $CI->load->library('session');

        if($messages = $CI->session->flashdata('messages'))
        {
            $this->_messages = $messages;
        }

        $CI->load->vars('messages', $this);

        log_message('debug', "Messages Class Initialized");
    }

    // --------------------------------------------------------------------

    /**
     * Initialize preferences
     *
     * @access    public
     * @param    array
     * @return    void
     */
    function initialize($config = array())
    {
        foreach ($config as $key => $val)
        {
            $this->{'_' . $key} = $val;
        }
    }

    // --------------------------------------------------------------------

    /**
    * Adding message
    * @param string $messageText
    * @param string $messageType
    */
    public function add($text='', $type='success')
    {
        if(trim($text)=='')
        {
            return;
        }
        if( ! isset($this->_message_wrapper[$type]))
        {
            trigger_error('Message Type <' . $type . '> is not supported');
            return ;
        }
        array_push($this->_messages, array(
            'type' => $type,
            'text' => $text
        ));
    }

    // --------------------------------------------------------------------

    /**
     * Get messages
     * @param boolean $wrapHtml
     */
    public function get($wrap = TRUE)
    {
        $this->_messages_showed = TRUE;
        return ($wrap) ? $this->_wrap_messages() : $this->_messages;
    }

    // --------------------------------------------------------------------

    /**
     * Wrap messages to Html
     */
    private function _wrap_messages()
    {
        $output = '';
        if (sizeof($this->_messages))
        {
            foreach ($this->_messages as $message)
            {
                $output.= sprintf($this->_message_wrapper[$message['type']], $message['text']);
            }
        }
        return sprintf($this->_message_block_wrapper,$output);
    }

    // --------------------------------------------------------------------

    function __toString()
    {
        return $this->get(TRUE);
    }

}