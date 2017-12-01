<?php
namespace kordar\ams\controllers;

use kordar\ams\web\Response;
use Yii;
use yii\base\Exception;


class RbacController extends CommonController
{

    public function actions()
    {
        return [];
    }

    /**
     * @inheritdoc
     */
    protected function verbs()
    {
        return [];
    }

    // 创建权限节点
    public function actionCreatePermission($item, $desc = '')
    {
        try {
            $auth = Yii::$app->authManager;
            $createPost = $auth->createPermission($item);
            $createPost->description = $desc ? : '创建了 ' . $item . ' 许可';
            if ($auth->add($createPost)) {
                return Response::sendCustomer(Response::$successStatus, $createPost->description);
            }
        } catch (Exception $e) {}

        return Response::sendCustomer(Response::$failedStatus, '权限节点创建失败!');
    }

    // 删除权限节点 | 角色 | rule
    public function actionRemoveNode($name, $type = 'permission')
    {
        try {

            $auth = Yii::$app->authManager;

            $obj = null;
            switch ($type) {
                case 'role':
                    $obj = $auth->getRole($name);
                    break;
                case 'rule':
                    $obj = $auth->getRule($name);
                    break;
                default:
                    $obj = $auth->getPermission($name);
            }

            if ($auth->remove($obj)) {
                return Response::sendCustomer(Response::$successStatus, '成功删除权限节点');
            }
        } catch (Exception $e) {}

        return Response::sendCustomer(Response::$failedStatus, '权限节点删除失败');
    }

    // 权限节点列表
    public function actionPermissionList()
    {
        $auth = Yii::$app->authManager;
        return $auth->getPermissions();
    }

    // 创建角色节点
    public function actionCreateRole($role, $desc = '')
    {
        try {
            $auth = Yii::$app->authManager;
            $roleObj = $auth->createRole($role);
            $roleObj->description = $desc ? : '创建了 ' . $role . ' 角色';
            if ($auth->add($roleObj)) {
                return Response::sendCustomer(Response::$successStatus, $roleObj->description);
            }
        } catch (Exception $e) {}
        return Response::sendCustomer(Response::$failedStatus, '角色创建失败!');
    }

    // 获取角色列表
    public function actionRoleList()
    {
        $auth = Yii::$app->authManager;
        return $auth->getRoles();
    }

    // 赋权
    public function actionEmpowerment()
    {
        try {

            $post = Yii::$app->getRequest()->getBodyParams();

            $auth = Yii::$app->authManager;
            $parent = $auth->getRole($post['role']);

            $auth->removeChildren($parent);

            foreach ($post['items'] as $item) {
                $child = $auth->getPermission($item);
                $auth->addChild($parent, $child);
            }
            return Response::sendCustomer(Response::$successStatus, '赋权完成');
        } catch (Exception $e) {}
        return Response::sendCustomer(Response::$failedStatus, '赋权失败!');
    }

    // 为用户分配权限
    public function actionAssign()
    {
        try {
            $auth = Yii::$app->authManager;
            $roles = Yii::$app->getRequest()->post('roles', []);

            $auth->revokeAll($this->userInfo['id']);

            foreach ($roles as $role) {
                $reader = $auth->getRole($role);
                $auth->assign($reader, $this->userInfo['id']);
            }
            return Response::sendCustomer(Response::$successStatus, '权限分配完成');
        } catch (Exception $e) {}
        return Response::sendCustomer(Response::$failedStatus, '权限分配失败');
    }


}