<?php
require_once('modules/te_ExpencePoPayment/te_ExpencePoPayment.php');
class te_ExpencePoPaymentprOverride extends te_ExpencePoPayment {
	public $dbinstance;
	function __construct(){
		parent::__construct();
		$this->dbinstance= DBManagerFactory::getInstance();
		 
	}
	
	public function deletePayment($exid,$id){
		//echo "delete from te_expencepopayment where exenseid='$exid' and id='$id'";
                //echo "delete from te_expencepopayment_cstm where  id_c='$id'"; die;
	   try{
                $this->dbinstance->query("delete from te_expencepopayment where exenseid='$exid' and id='$id'");		
		$this->dbinstance->query("delete from te_expencepopayment_cstm where  id_c='$id'");		
	        return true;
          }catch(Exception $e){
            return false;
          }	
	}
	
	public function getLastPayment($id){
		
		$itemDetal=	$this->dbinstance->query("select p.id from te_expencepopayment as p inner join te_expencepopayment_cstm as d on d.id_c=p.id where p.exenseid='$id' and p.is_last_payment=1 and d.status_c<>0");
		$statrus=$this->dbinstance->fetchByAssoc($itemDetal);
		return ($statrus && count($statrus)>0)? true : false ;
	}
	
	public function getRaisedPayment($id){
		//echo "select sum(amount)+sum(tax) as totalamt from te_expencepopayment where exenseid='$id'";
		$itemDetal=	$this->dbinstance->query("select sum(amount)+sum(tax) as totalamt from te_expencepopayment as p inner join  te_expencepopayment_cstm as d on d.id_c=p.id where p.exenseid='$id' and d.status_c<>0");
		$statrus=$this->dbinstance->fetchByAssoc($itemDetal);
		return ($statrus && count($statrus)>0)? $statrus['totalamt'] : false ;
	}
	
    private function _checkOptimisticLockingOverride($action, $isUpdate)
    {
        if ($this->optimistic_lock && !isset($_SESSION['o_lock_fs'])) {
            if (isset($_SESSION['o_lock_id']) && $_SESSION['o_lock_id'] == $this->id && $_SESSION['o_lock_on'] == $this->object_name) {
                if ($action == 'Save' && $isUpdate && isset($this->modified_user_id) && $this->has_been_modified_since($_SESSION['o_lock_dm'], $this->modified_user_id)) {
                    $_SESSION['o_lock_class'] = get_class($this);
                    $_SESSION['o_lock_module'] = $this->module_dir;
                    $_SESSION['o_lock_object'] = $this->toArray();
                    $saveform = "<form name='save' id='save' method='POST'>";
                    foreach ($_POST as $key => $arg) {
                        $saveform .= "<input type='hidden' name='" . addslashes($key) . "' value='" . addslashes($arg) . "'>";
                    }
                    $saveform .= "</form><script>document.getElementById('save').submit();</script>";
                    $_SESSION['o_lock_save'] = $saveform;
                    header('Location: index.php?module=OptimisticLock&action=LockResolve');
                    die();
                } else {
                    unset($_SESSION['o_lock_object']);
                    unset($_SESSION['o_lock_id']);
                    unset($_SESSION['o_lock_dm']);
                }
            }
        } else {
            if (isset($_SESSION['o_lock_object'])) {
                unset($_SESSION['o_lock_object']);
            }
            if (isset($_SESSION['o_lock_id'])) {
                unset($_SESSION['o_lock_id']);
            }
            if (isset($_SESSION['o_lock_dm'])) {
                unset($_SESSION['o_lock_dm']);
            }
            if (isset($_SESSION['o_lock_fs'])) {
                unset($_SESSION['o_lock_fs']);
            }
            if (isset($_SESSION['o_lock_save'])) {
                unset($_SESSION['o_lock_save']);
            }
        }
    }	
	
	//ovverride
	public function save($check_notify = false)
    {
        
        
        $this->in_save = true;
        // cn: SECURITY - strip XSS potential vectors
        $this->cleanBean();
        // This is used so custom/3rd-party code can be upgraded with fewer issues, this will be removed in a future release
        $this->fixUpFormatting();
        global $current_user, $action;

        $isUpdate = true;
        if (empty($this->id)) {
            $isUpdate = false;
        }

        if ($this->new_with_id == true) {
            $isUpdate = false;
        }
        if (empty($this->date_modified) || $this->update_date_modified) {
            $this->date_modified = $GLOBALS['timedate']->nowDb();
        }

        $this->_checkOptimisticLockingOverride($action, $isUpdate);

        if (!empty($this->modified_by_name)) {
            $this->old_modified_by_name = $this->modified_by_name;
        }
        if ($this->update_modified_by) {
            $this->modified_user_id = 1;

            if (!empty($current_user)) {
                $this->modified_user_id = $current_user->id;
                $this->modified_by_name = $current_user->user_name;
            }
        }
        if ($this->deleted != 1) {
            $this->deleted = 0;
        }
        if (!$isUpdate) {
            if (!empty($this->date_entered_c)) {
                $this->date_entered = $this->date_entered_c;
            }
            if (empty($this->date_entered)) {
                $this->date_entered = $this->date_modified;
            }
           
            if ($this->set_created_by == true) {
                // created by should always be this user
                $this->created_by = (isset($current_user)) ? $current_user->id : "";
            }
            if ($this->new_with_id == false) {
                $this->id = create_guid();
            }
        }


        require_once("data/BeanFactory.php");
        BeanFactory::registerBean($this->module_name, $this);

        if (empty($GLOBALS['updating_relationships']) && empty($GLOBALS['saving_relationships']) && empty($GLOBALS['resavingRelatedBeans'])) {
            $GLOBALS['saving_relationships'] = true;
            // let subclasses save related field changes
            $this->save_relationship_changes($isUpdate);
            $GLOBALS['saving_relationships'] = false;
        }
        if ($isUpdate && !$this->update_date_entered) {
            unset($this->date_entered);
        }
        // call the custom business logic
        $custom_logic_arguments['check_notify'] = $check_notify;


        $this->call_custom_logic("before_save", $custom_logic_arguments);
        unset($custom_logic_arguments);

        // If we're importing back semi-colon separated non-primary emails
        if ($this->hasEmails() && !empty($this->email_addresses_non_primary) && is_array($this->email_addresses_non_primary)) {
            // Add each mail to the account
            foreach ($this->email_addresses_non_primary as $mail) {
                $this->emailAddress->addAddress($mail);
            }
            $this->emailAddress->save($this->id, $this->module_dir);
        }

        if (isset($this->custom_fields)) {
            $this->custom_fields->bean = $this;
            $this->custom_fields->save($isUpdate);
        }

        // use the db independent query generator
        $this->preprocess_fields_on_save();

       

        if ($isUpdate) {
            $this->db->update($this);
        } else {
			
            $this->db->insert($this);
        }

        if (empty($GLOBALS['resavingRelatedBeans'])) {
            SugarRelationship::resaveRelatedBeans();
        }

        /* BEGIN - SECURITY GROUPS - inheritance */
        require_once('modules/SecurityGroups/SecurityGroup.php');
        SecurityGroup::inherit($this, $isUpdate);
        /* END - SECURITY GROUPS */
        //If we aren't in setup mode and we have a current user and module, then we track
        if (isset($GLOBALS['current_user']) && isset($this->module_dir)) {
            $this->track_view($current_user->id, $this->module_dir, 'save');
        }

        $this->call_custom_logic('after_save', '');

        $this->auditBean($isUpdate);

        //Now that the record has been saved, we don't want to insert again on further saves
        $this->new_with_id = false;
        $this->in_save = false;
        return $this->id;
    }


	
	
	
}	
