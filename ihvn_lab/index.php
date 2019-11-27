<?php 
const DB_SERVER = "localhost";
const DB_NAME = "employees";
const DB_USER = "root";
const DB_PASS = "";
try{
    $database = new PDO("mysql:host=" . DB_SERVER . ";dbname=" .DB_NAME . "",'' . DB_USER . '','' .DB_PASS . '');

//$database = new PDO("mysql:host=DB_SERVER;dbname=compsci",'DB_USER','DB_PASS');
} catch(PDOException $e)
{
    echo $e->getMessage();
}	
$database->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
$database->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$database->setAttribute(PDO::ATTR_CASE, PDO::CASE_LOWER);

$sql = "SELECT employees.emp_no, employees.birth_date, employees.first_name, employees.last_name, 
        employees.gender, employees.hire_date, departments.dept_name ";
$sql .= " FROM employees ";
$sql .= " JOIN dept_emp ON dept_emp.emp_no=employees.emp_no ";
$sql .= " JOIN departments ON departments.dept_no=dept_emp.dept_no ";
$sql .= " WHERE dept_emp.dept_no IN (SELECT dept_no FROM dept_emp WHERE emp_no=10003)";
$result = $database->prepare($sql);
$result->execute();
$employees = $result->fetchAll(PDO::FETCH_OBJ);

?>
<html>
<head><title>Employee Sample</title>
<style>
    table{
        border-collapse:collapse;
    }
    td, th{
        padding:10px;
    }
</style>
</head>
<body>
<table  border="1">
    <thead>
        <th>Employee No</th>
        <th>Department</th>
        <th>First Name</th>
        <th>Last Name </th>
        <th>Gender</th>
        <th>Hire Date</th>
    </thead>
    <tbody>
        <?php 
            foreach($employees as $employee)
            {?>
        <tr>
            <td><?php echo $employee->emp_no?></td>
            <td><?php echo $employee->dept_name?></td>
            <td><?php echo $employee->first_name?></td>
            <td><?php echo $employee->last_name?></td>
            <td><?php echo $employee->gender?></td>
            <td><?php echo $employee->hire_date?></td>
        </tr>
    <?php  }
        ?>
    </tbody>
</table>
    
</body>
</html>