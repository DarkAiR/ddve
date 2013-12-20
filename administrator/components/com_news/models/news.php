<?php
// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport('joomla.application.component.model');

class NewsListModelNews extends JModel
{
    const MAIN_IMAGE_WIDTH = 150;

    /**
     * Constructor that retrieves the ID from the request
     *
     * @access  public
     * @return  void
     */
    function __construct()
    {
        parent::__construct();

        $array = JRequest::getVar('cid',  0, '', 'array');
        $this->setId((int)$array[0]);
    }

    function setId($id)
    {
        // Set id and wipe data
        $this->_id      = $id;
        $this->_data    = null;
    }

    function &getData()
    {
        // Load the data
        if (empty( $this->_data )) {
            $query = ' SELECT * FROM #__news '.
                    '  WHERE id = '.$this->_id;
            $this->_db->setQuery( $query );
            $this->_data = $this->_db->loadObject();
        }
        if (!$this->_data) {
            $this->_data = new stdClass();
            $this->_data->id = 0;
            $this->_data->title = null;
            $this->_data->fulltext = null;
            $this->_data->mainimage = 0;
            $this->_data->date = null;
            $this->_data->ordering = null;
            $this->_data->published = 1;
        }
        return $this->_data;
    }

    public function getStorePath()
    {
        return '/media/news/';
    }
    /**
     * Method to store a record
     *
     * @access  public
     * @return  boolean True on success
     */
    function store()
    {
        jimport('joomla.filesystem.imageupload');

        $row =& $this->getTable();

        $data = JRequest::get( 'post', 2 );
        $files = JRequest::get( 'files', 2 );
        $needUpload = JImageUpload::needUpload($files, 'mainimage');

        if (isset($data['id']) && $data['id'] > 0)
        {
            $query = ' SELECT * FROM #__news '.
                    '  WHERE id = '.$data['id'];
            $this->_db->setQuery( $query );
            $newsData = $this->_db->loadObject();

            if ($needUpload)
                JImageUpload::deleteOldFile($files, 'mainimage', $newsData, 'mainimage');
        }

        if ($needUpload)
        {
            $fileName = JImageUpload::upload($files, 'mainimage', $this->getStorePath(), self::MAIN_IMAGE_WIDTH );
            if ($fileName === false)
            {
                $this->setError('Image upload have broken, code = '.JImageUpload::getLastError());
                return false;
            }
            $data['mainimage'] = $this->getStorePath().$fileName;
        }

        // Bind the form fields to the news table
        if (!$row->bind($data))
        {
            $this->setError($this->_db->getErrorMsg());
            return false;
        }

        // Make sure the news record is valid
        if (!$row->check())
        {
            $this->setError($this->_db->getErrorMsg());
            return false;
        }

        // Store the web link table to the database
        if (!$row->store())
        {
            $this->setError( $row->getErrorMsg() );
            return false;
        }

        return true;
    }

    /**
     * Method to delete record(s)
     *
     * @access  public
     * @return  boolean True on success
     */
    function delete()
    {
        $cids = JRequest::getVar( 'cid', array(0), 'post', 'array' );

        $row =& $this->getTable();

        if (count( $cids )) {
            foreach($cids as $cid) {
                if (!$row->delete( $cid )) {
                    $this->setError( $row->getErrorMsg() );
                    return false;
                }
            }
        }
        return true;
    }

}