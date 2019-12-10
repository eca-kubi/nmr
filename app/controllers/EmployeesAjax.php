<?php

class EmployeesAjax extends Controller
{

    public function index(): void {
        try {
           $employees =  Database::getDbh()->join('departments d', 'd.department_id=u.department_id', 'LEFT')
               ->orderBy('name', 'ASC')
                ->get('users u', null, 'concat_ws(" ", u.first_name, u.last_name) as name, u.user_id,  d.short_name as department_short_name');
           echo json_encode($employees, JSON_THROW_ON_ERROR, 512);
           return;
        } catch (Exception $e) {
        }
        echo json_encode([], JSON_THROW_ON_ERROR, 512);
    }
}