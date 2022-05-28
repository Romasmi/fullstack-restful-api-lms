<?php

namespace App\Controller;
use \App\Model\Student;

class StudentController extends Controller
{
    private Student $student;

    public function __construct()
    {
        parent::__construct();
        $this->student = new Student();
    }

    public function handleRequest(): array
    {
        return match ($this->methodType) {
            'GET' => $this->OnGetStudents(),
            default => $this->handleBadRequest(),
        };
    }

    private function OnGetStudents() : array
    {
        $data = $this->getQueryStringData();
        $offset = STUDENTS_PER_PAGE * ($data['page'] - 1);
        $limit =  STUDENTS_PER_PAGE;
        return $this->prepareResponse([
            'status' => 'success',
            'students' => $this->student->getStudents($offset, $limit),
            'count' => $this->student->getCount(),
            'countPerPage' => STUDENTS_PER_PAGE,
            'page' => $data['page']
        ], 200);
    }
}