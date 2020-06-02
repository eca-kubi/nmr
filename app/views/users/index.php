<?php include_once(APP_ROOT . '/views/includes/styles.php'); ?>
<?php include_once(APP_ROOT . '/views/includes/navbar.php'); ?>
<?php include_once(APP_ROOT . '/views/includes/sidebar.php'); ?>
<!-- .content-wrapper -->
<div class="content-wrapper animated fadeInRight">
    <!-- content -->
    <section class="content blockable d-none">
        <div class="box-group pt-1" id="box_group">
            <div class="box collapsed border-primary">
                <div class="box-header">
                    <h3 class="box-title text-bold text-success">
                        <?php echo $title ?? ''; ?>
                    </h3>
                    <div class="box-tools pull-right d-none">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse">
                            <i class="fa fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="box-body">
                    <div class="row">
                        <table id="kGridUsers">
                          <!--  <colgroup>
                                <col style="width: 10%"/>
                                <col style="width: 100px"/>
                                <col/>
                                <col/>
                                <col/>
                                <col/>
                                <col style="width: 200px"/>
                            </colgroup>-->
                            <thead>
                            <tr>
                                <th></th>
                                <th data-field="user_id">ID</th>
                                <th data-field="name">Name</th>
                                <th data-field="username">Username</th>
                                <th data-field="department">Department</th>
                                <th data-field="position">Position</th>
                                <th data-field="email">Email</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php /*foreach ($users as $user) { */ ?><!--
                                <tr>
                                    <td data-field="user_id"><?php /*echo $user->user_id; */ ?></td>
                                    <td data-field="name"
                                        class="k-text-capitalize"><?php /*echo $user->first_name . ' ' . $user->last_name; */ ?></td>
                                    <td data-field="username"><?php /*echo $user->staff_id; */ ?></td>
                                    <td data-field="department"><?php /*echo getDepartment($user->department_id); */ ?></td>
                                    <td data-field="position"><?php /*echo $user->job_title; */ ?></td>
                                    <td data-field="email"><?php /*echo $user->email; */ ?></td>
                                </tr>
                            --><?php /*} */ ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="box-footer d-none"></div>
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<?php include_once(APP_ROOT . '/views/includes/footer.php'); ?>
</div>
<!-- /.wrapper -->
<?php include_once(APP_ROOT . '/views/includes/scripts.php'); ?>
<?php include_once(APP_ROOT . '/templates/kendo-templates.html'); ?>

<script>
    $(function () {
        $('#kGridUsers').kendoGrid({
            //height: 550,
            sortable: true,
            groupable: {messages: {empty: "Drag Columns Here to Group"}},
            toolbar: ["search", 'create', 'save', 'cancel'],
            search: {
                fields: ['department', 'name', 'position', 'username', 'email']
            },
            dataSource: {
                schema: {
                    model: {
                        id: "user_id",
                        fields: {
                            user_id: {type: "number", editable: false},
                            department: {type: "number"}
                        }
                    }
                },
                transport: {
                    read: {
                        url: URL_ROOT + "/users/read",
                        dataType: "json"
                    },
                    create: {
                        url: URL_ROOT + "/users/create",
                        type: 'POST'
                    }
                }
            },
            columns: [
                {command: "edit", title: ''},
                {field: "user_id", title: '', hidden: true},
                {field: "name", title: 'Name'},
                {field: "username", title: 'Username'},
                {
                    field: "department",
                    title: "Department",
                    editor: function (container, options) {
                        $('<input name="' + options.field + '" required="required" data-required-msg="Department is required!"  />').appendTo(container).kendoComboBox({
                            dataTextField: "text",
                            dataValueField: "value",
                            dataSource: {
                                transport: {
                                    read: {
                                        url: URL_ROOT + '/users/departments',
                                        dataType: "json"
                                    }
                                },
                            },
                            filter: "contains",
                            suggest: true,
                            index: 0
                        });
                        let tooltipElement = $('<span class="k-invalid-msg" data-for="' + options.field + '"></span>');
                        tooltipElement.appendTo(container);
                    },
                    values: JSON.parse(`<?php echo json_encode(getDepartments()); ?>`).map(function (dept) {
                        return {text: dept.department, value: dept.department_id}
                    })
                },
                {field: "position", title: 'Position'},
                {field: "email", title: 'Email'}
            ],
            editable: {mode: "popup"},
            edit(e) {
                e.container.find(".k-edit-label:first").hide();
                e.container.find(".k-edit-field:first").hide();
            }
        });
    });
</script>
</body>
</html>
