<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Audit_model
 * Enterprise audit trail for tracking user actions.
 */
class Audit_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }

    /**
     * Log an action to the audit trail.
     *
     * @param string $action  Description of the action (e.g., "Created invoice #123")
     * @param string $module  Module name (e.g., "finance", "admission", "system")
     * @return void
     */
    function log($action, $module = 'general')
    {
        $data = array(
            'tenant_id'  => $this->session->userdata('tenant_id') ? $this->session->userdata('tenant_id') : 1,
            'user_id'    => $this->session->userdata('login_user_id'),
            'user_name'  => $this->session->userdata('name'),
            'role'       => $this->session->userdata('login_type'),
            'action'     => $action,
            'module'     => $module,
            'ip_address' => $this->input->ip_address(),
        );
        $this->db->insert('audit_logs', $data);
    }

    /**
     * Get audit logs with optional filters.
     *
     * @param array $filters  Optional filters: user_id, module, date_from, date_to
     * @param int   $limit    Max records to return
     * @return array
     */
    function get_logs($filters = array(), $limit = 100)
    {
        if (!empty($filters['user_id'])) {
            $this->db->where('user_id', $filters['user_id']);
        }
        if (!empty($filters['module'])) {
            $this->db->where('module', $filters['module']);
        }
        if (!empty($filters['date_from'])) {
            $this->db->where('created_at >=', $filters['date_from'] . ' 00:00:00');
        }
        if (!empty($filters['date_to'])) {
            $this->db->where('created_at <=', $filters['date_to'] . ' 23:59:59');
        }

        $tenant_id = $this->session->userdata('tenant_id') ? $this->session->userdata('tenant_id') : 1;
        $this->db->where('tenant_id', $tenant_id);
        $this->db->order_by('created_at', 'desc');
        $this->db->limit($limit);
        return $this->db->get('audit_logs')->result_array();
    }
}
