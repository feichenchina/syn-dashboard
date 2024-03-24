<?php

namespace App\Admin\Controllers;

use App\Models\Student;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Illuminate\Support\Facades\Hash;

class StudentController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '学生';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Student());

        $grid->column('id', __('Id'));
        $grid->column('name', '姓名');
        $grid->column('email', "邮箱");
        $grid->column('remark', __('备注'));
        $grid->column('created_at', __('创建时间'));
        $grid->model()->orderBy('id', 'desc');

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(Student::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('name', '姓名');
        $show->field('email', '邮箱');
        $show->field('remark', __('备注'));
        $show->field('created_at', __('创建时间'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Student());

        $form->text('name', '姓名')->required();

        $form->email('email', __('邮箱'))
            ->creationRules(['required', "unique:student"], [
                'required' => '邮箱必填',
                'unique' => '邮箱已经被使用',
            ])
            ->updateRules(['required', "unique:student,email,{{id}}"], [
                'required' => '邮箱必填',
                'unique' => '邮箱已经被使用',
            ]);

        $form->password('password', '密码')->required()->default(function ($form) {
            return $form->model()->password;
        });
        $form->text('remark', __('备注'));
        $form->saving(function (Form $form) {
            if ($form->password) {
                $form->password = Hash::make($form->password);
            }
        });
        return $form;
    }

    /**
     * 更新操作
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {
        $data = request()->all();
        // if (empty($data['password'])) {
        //     unset($data['password']);
        // }
        return $this->form()->update($id, $data);
    }
}
