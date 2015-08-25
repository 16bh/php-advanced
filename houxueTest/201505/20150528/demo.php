<?php
/**
 * @author:  chenxi
 * @date:    2015-05-28
 * @version: $Id$
 */
class Model_Org_Department{

    public function getDepartmentOptions($selectid = 0)
    {
        /* 简单的数据范围权限验证，只有超级管理员才能显示所有部门 */
        $userGroupIds = $this->session->get('admin_user_role_ids');
        $userId = $this->session->get('admin_user_id');
        if ($userId == SUPPER_ADMIN_ID || $userGroupIds == SUPPER_ROLE_ID || $userGroupIds == ADMIN_ROLE_ID) {
            $pid = 0;
        } else {
            $userinfo = (new Model_Org_User())->getUserByUid($this->session->get('admin_user_id'));
            $pid = isset($userinfo['department_id']) ? intval($userinfo['department_id']) : -1;
        }
        $cate_tree = $this->getDepartCate($pid, false, 1);
        $options = '<option value="0">----无----</option>';
        foreach ($cate_tree as $cat) {
            if ($selectid > 0 && $selectid == $cat['id']) {
                $selected = 'selected="true"';
            } else {
                $selected = '';
            }
            if ($cat['depath'] == 1) {
                $options .= sprintf('<option value="%d" %s>├ %s</option>', $cat['id'], $selected, $cat['name']);
            } else {
                $options .= sprintf('<option value="%d" %s>%s├ %s</option>', $cat['id'], $selected,
                    str_repeat('&nbsp;', $cat['depath'] * 2), $cat['name']);
            }
        }
        return $options;
    }
}