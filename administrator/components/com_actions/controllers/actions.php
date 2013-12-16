<?php
// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

class ActionsListControllerActions extends ActionsListController
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
        JRequest::setVar( 'view', 'actions' );
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
        $model = $this->getModel('actions');

        $post;
        $msg = $model->store($post)
            ? JText::_( 'Saved!' )
            : JText::_( 'Error Saving' );

        // Check the table in so it can be edited.... we are done with it anyway
        $link = 'index.php?option=com_actions';
        $this->setRedirect($link, $msg);
    }

    /**
     * remove record(s)
     * @return void
     */
    public function remove()
    {
        $model = $this->getModel('actions');
        if(!$model->delete()) {
            $msg = JText::_( 'Error: One or More Actions Could not be Deleted' );
        } else {
            $msg = JText::_( 'Action(s) Deleted' );
        }

        $this->setRedirect( 'index.php?option=com_actions', $msg );
    }

    /**
     * cancel editing a record
     * @return void
     */
    public function cancel()
    {
        $msg = JText::_( 'Operation Cancelled' );
        $this->setRedirect( 'index.php?option=com_actions', $msg );
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
        JTable::addIncludePath(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_actions'.DS.'tables');
        $row =& JTable::getInstance('actions', 'Table');
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
        $mainframe->redirect( 'index.php?option=com_actions', $msg );
    }

    public function orderup()
    {
        $cid = JRequest::getVar( 'cid', array(0), 'post', 'array' );
        $this->orderActions($cid[0], -1);
    }

    public function orderdown()
    {
        $cid = JRequest::getVar( 'cid', array(0), 'post', 'array' );
        $this->orderActions($cid[0], 1);
    }

    public function publish()
    {
        $cid = JRequest::getVar( 'cid', array(0), 'post', 'array' );
        $this->changeActions( $cid, 1 );
    }

    public function unpublish()
    {
        $cid = JRequest::getVar( 'cid', array(0), 'post', 'array' );
        $this->changeActions( $cid, 0 );
    }

    private function orderActions( $uid, $inc )
    {
        global $mainframe;

        // Set the table directory
        JTable::addIncludePath(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_actions'.DS.'tables');
        $row =& JTable::getInstance('actions', 'Table');
        $row->load( (int)$uid );
        $row->move( $inc );

        $mainframe->redirect( 'index.php?option=com_actions' );
    }

    private function changeActions( $cid=null, $state=0 )
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

        $query = 'UPDATE #__actions SET published = ' . (int)$state . ' WHERE id IN ('.$cids.')';
        $db->setQuery( $query );
        if (!$db->query())
            JError::raiseError(500, $db->getErrorMsg() );

        if (count( $cid ) == 1)
        {
            // Set the table directory
            JTable::addIncludePath(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_actions'.DS.'tables');
            $row =& JTable::getInstance('actions', 'Table');
            $row->checkin( intval( $cid[0] ) );
        }

        $mainframe->redirect( 'index.php?option=com_actions' );
    }
}