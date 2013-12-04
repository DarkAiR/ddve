<?php
// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

class VacancysControllerVacancy extends VacancysController
{
    /**
     * constructor (registers additional tasks to methods)
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        // Register Extra tasks
        $this->registerTask( 'add', 'edit' );
    }

    /**
     * display the edit form
     * @return void
     */
    public function edit()
    {
        JRequest::setVar( 'view', 'vacancy' );
        JRequest::setVar( 'layout', 'form'  );
        JRequest::setVar( 'hidemainmenu', 1 );

        parent::display();
    }

    /**
     * save a record (and redirect to main page)
     * @return void
     */
    public function save()
    {
        $model = $this->getModel('vacancy');

        $post;
        $msg = $model->store($post)
            ? JText::_( 'Saved!' )
            : JText::_( 'Error Saving' );

        // Check the table in so it can be edited.... we are done with it anyway
        $link = 'index.php?option=com_vacancy';
        $this->setRedirect($link, $msg);
    }

    /**
     * remove record(s)
     * @return void
     */
    public function remove()
    {
        $model = $this->getModel('vacancy');
        if(!$model->delete()) {
            $msg = JText::_( 'Error: One or More Vacancies Could not be Deleted' );
        } else {
            $msg = JText::_( 'Vacancy(s) Deleted' );
        }

        $this->setRedirect( 'index.php?option=com_vacancy', $msg );
    }

    /**
     * cancel editing a record
     * @return void
     */
    public function cancel()
    {
        $msg = JText::_( 'Operation Cancelled' );
        $this->setRedirect( 'index.php?option=com_vacancy', $msg );
    }

    public function saveOrder()
    {
        global $mainframe;

        // Initialize variables
        $db         =& JFactory::getDBO();
        $cid        = JRequest::getVar( 'cid', array(0), 'post', 'array' );
        $order      = JRequest::getVar( 'order', array(0), 'post', 'array' );
        $total      = count( $cid );
        JArrayHelper::toInteger($cid, array(0));
        JArrayHelper::toInteger($order, array(0));

        // Set the table directory
        JTable::addIncludePath(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_vacancy'.DS.'tables');
        $row =& JTable::getInstance('vacancy', 'Table');
        $groupings = array();

        // update ordering values
        for( $i=0; $i < $total; $i++ )
        {
            $row->load( (int)$cid[$i] );
            // track categories
            $groupings[] = $row->catid;

            if ($row->ordering != $order[$i])
            {
                $row->ordering = $order[$i];
                if (!$row->store())
                    JError::raiseError(500, $db->getErrorMsg() );
            }
        }

        $msg    = 'New ordering saved';
        $mainframe->redirect( 'index.php?option=com_vacancy', $msg );
    }

    public function orderup()
    {
        $cid = JRequest::getVar( 'cid', array(0), 'post', 'array' );
        $this->orderVacancy($cid[0], -1);
    }

    public function orderdown()
    {
        $cid = JRequest::getVar( 'cid', array(0), 'post', 'array' );
        $this->orderVacancy($cid[0], 1);
    }

    public function publish()
    {
        $cid = JRequest::getVar( 'cid', array(0), 'post', 'array' );
        $this->changeVacancy( $cid, 1 );
    }

    public function unpublish()
    {
        $cid = JRequest::getVar( 'cid', array(0), 'post', 'array' );
        $this->changeVacancy( $cid, 0 );
    }

    private function orderVacancy( $uid, $inc )
    {
        global $mainframe;

        // Set the table directory
        JTable::addIncludePath(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_vacancy'.DS.'tables');
        $row =& JTable::getInstance('vacancy', 'Table');
        $row->load( (int)$uid );
        $row->move( $inc );

        $mainframe->redirect( 'index.php?option=com_vacancy' );
    }

    private function changeVacancy( $cid=null, $state=0 )
    {
        global $mainframe;

        // Initialize variables
        $db =& JFactory::getDBO();
        JArrayHelper::toInteger($cid);

        if (count( $cid ) < 1)
        {
            $action = $state ? 'publish' : 'unpublish';
            JError::raiseError(500, JText::_( 'Select an item to' .$action, true ) );
        }

        $cids = implode( ',', $cid );

        $query = 'UPDATE #__vacancy SET published = ' . (int)$state . ' WHERE id IN ('.$cids.')';
        $db->setQuery( $query );
        if (!$db->query())
            JError::raiseError(500, $db->getErrorMsg() );

        if (count( $cid ) == 1)
        {
            // Set the table directory
            JTable::addIncludePath(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_vacancy'.DS.'tables');
            $row =& JTable::getInstance('vacancy', 'Table');
            $row->checkin( intval( $cid[0] ) );
        }

        $mainframe->redirect( 'index.php?option=com_vacancy' );
    }
}