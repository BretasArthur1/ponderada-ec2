<?php include "../inc/dbinfo.inc"; ?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Gerenciamento - AWS EC2</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 20px;
            background-color: #f5f5f5;
            color: #333;
        }
        
        h1, h2 {
            color: #2c3e50;
            text-align: center;
            margin-bottom: 20px;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
            margin-bottom: 20px;
        }
        
        form {
            margin-bottom: 30px;
        }
        
        .form-group {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            margin-bottom: 15px;
        }
        
        .form-control {
            flex: 1;
            min-width: 200px;
        }
        
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        
        input[type="text"],
        input[type="number"] {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }
        
        button, input[type="submit"] {
            background-color: #3498db;
            color: white;
            border: none;
            padding: 10px 15px;
            cursor: pointer;
            border-radius: 4px;
            font-size: 16px;
        }
        
        button:hover, input[type="submit"]:hover {
            background-color: #2980b9;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        
        th {
            background-color: #3498db;
            color: white;
        }
        
        tr:hover {
            background-color: #f5f5f5;
        }
        
        .section-title {
            border-bottom: 2px solid #3498db;
            padding-bottom: 10px;
            margin-top: 30px;
        }
        
        .error {
            color: #e74c3c;
            background-color: #fadbd8;
            padding: 10px;
            border-radius: 4px;
            margin-bottom: 15px;
        }
        
        .success {
            color: #27ae60;
            background-color: #d4efdf;
            padding: 10px;
            border-radius: 4px;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Ponderada AWS EC2 + DB - Arthur Bretas</h1>
        
        <?php
          /* Conectar ao MySQL */
          $connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);
          if (mysqli_connect_errno()) {
              echo "<div class='error'>Failed to connect to MySQL: " . mysqli_connect_error() . "</div>";
          }

          $database = mysqli_select_db($connection, DB_DATABASE);

          /* Criar/verificar tabelas */
          VerifyEmployeesTable($connection, DB_DATABASE);
          VerifyDepartmentsTable($connection, DB_DATABASE);

          /* Processar formulário de funcionários */
          if (isset($_POST['employee_submit'])) {
              $employee_name = htmlentities($_POST['NAME']);
              $employee_address = htmlentities($_POST['ADDRESS']);
              $employee_age = (int) $_POST['AGE'];
              $employee_salary = (float) $_POST['SALARY'];

              if (!empty($employee_name) && !empty($employee_address)) {
                AddEmployee($connection, $employee_name, $employee_address, $employee_age, $employee_salary);
                echo "<div class='success'>Funcionário adicionado com sucesso!</div>";
              }
          }
          
          /* Processar formulário de departamentos */
          if (isset($_POST['department_submit'])) {
              $department_name = htmlentities($_POST['DEPT_NAME']);
              $department_location = htmlentities($_POST['LOCATION']);
              $department_budget = (float) $_POST['BUDGET'];

              if (!empty($department_name) && !empty($department_location)) {
                AddDepartment($connection, $department_name, $department_location, $department_budget);
                echo "<div class='success'>Departamento adicionado com sucesso!</div>";
              }
          }
        ?>

        <!-- Seção de Funcionários -->
        <h2 class="section-title">Gerenciamento de Funcionários</h2>
        
        <form action="<?php echo $_SERVER['SCRIPT_NAME'] ?>" method="POST">
            <div class="form-group">
                <div class="form-control">
                    <label for="name">Nome:</label>
                    <input type="text" id="name" name="NAME" maxlength="45" required />
                </div>
                
                <div class="form-control">
                    <label for="address">Endereço:</label>
                    <input type="text" id="address" name="ADDRESS" maxlength="90" required />
                </div>
                
                <div class="form-control">
                    <label for="age">Idade:</label>
                    <input type="number" id="age" name="AGE" min="18" required />
                </div>
                
                <div class="form-control">
                    <label for="salary">Salário:</label>
                    <input type="number" id="salary" name="SALARY" step="0.01" required />
                </div>
                
                <div class="form-control" style="align-self: flex-end;">
                    <input type="submit" name="employee_submit" value="Adicionar Funcionário" />
                </div>
            </div>
        </form>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Endereço</th>
                    <th>Idade</th>
                    <th>Salário</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $result = mysqli_query($connection, "SELECT * FROM EMPLOYEES");

                while($query_data = mysqli_fetch_row($result)) {
                  echo "<tr>
                          <td>$query_data[0]</td>
                          <td>$query_data[1]</td>
                          <td>$query_data[2]</td>
                          <td>$query_data[3]</td>
                          <td>R$ " . number_format($query_data[4], 2, ',', '.') . "</td>
                        </tr>";
                }
                mysqli_free_result($result);
                ?>
            </tbody>
        </table>
        
        <!-- Seção de Departamentos -->
        <h2 class="section-title">Gerenciamento de Departamentos</h2>
        
        <form action="<?php echo $_SERVER['SCRIPT_NAME'] ?>" method="POST">
            <div class="form-group">
                <div class="form-control">
                    <label for="dept_name">Nome do Departamento:</label>
                    <input type="text" id="dept_name" name="DEPT_NAME" maxlength="45" required />
                </div>
                
                <div class="form-control">
                    <label for="location">Localização:</label>
                    <input type="text" id="location" name="LOCATION" maxlength="90" required />
                </div>
                
                <div class="form-control">
                    <label for="budget">Orçamento:</label>
                    <input type="number" id="budget" name="BUDGET" step="0.01" required />
                </div>
                
                <div class="form-control" style="align-self: flex-end;">
                    <input type="submit" name="department_submit" value="Adicionar Departamento" />
                </div>
            </div>
        </form>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome do Departamento</th>
                    <th>Localização</th>
                    <th>Orçamento</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $result = mysqli_query($connection, "SELECT * FROM DEPARTMENTS");

                while($query_data = mysqli_fetch_row($result)) {
                  echo "<tr>
                          <td>$query_data[0]</td>
                          <td>$query_data[1]</td>
                          <td>$query_data[2]</td>
                          <td>R$ " . number_format($query_data[3], 2, ',', '.') . "</td>
                        </tr>";
                }
                mysqli_free_result($result);
                mysqli_close($connection);
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>

<?php
/* Inserir funcionário */
function AddEmployee($connection, $name, $address, $age, $salary) {
   $n = mysqli_real_escape_string($connection, $name);
   $a = mysqli_real_escape_string($connection, $address);
   $age = (int) $age;
   $salary = (float) $salary;

   $query = "INSERT INTO EMPLOYEES (NAME, ADDRESS, AGE, SALARY) VALUES ('$n', '$a', $age, $salary);";

   if (!mysqli_query($connection, $query)) echo("<div class='error'>Erro ao adicionar funcionário.</div>");
}

/* Inserir departamento */
function AddDepartment($connection, $name, $location, $budget) {
   $n = mysqli_real_escape_string($connection, $name);
   $l = mysqli_real_escape_string($connection, $location);
   $budget = (float) $budget;

   $query = "INSERT INTO DEPARTMENTS (DEPT_NAME, LOCATION, BUDGET) VALUES ('$n', '$l', $budget);";

   if (!mysqli_query($connection, $query)) echo("<div class='error'>Erro ao adicionar departamento.</div>");
}

/* Criar/verificar tabela de funcionários */
function VerifyEmployeesTable($connection, $dbName) {
  if (!TableExists("EMPLOYEES", $connection, $dbName)) {
     $query = "CREATE TABLE EMPLOYEES (
         ID INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
         NAME VARCHAR(45),
         ADDRESS VARCHAR(90),
         AGE INT,
         SALARY DECIMAL(10,2)
       )";
     if (!mysqli_query($connection, $query)) echo("<div class='error'>Erro ao criar tabela de funcionários.</div>");
  }
}

/* Criar/verificar tabela de departamentos */
function VerifyDepartmentsTable($connection, $dbName) {
  if (!TableExists("DEPARTMENTS", $connection, $dbName)) {
     $query = "CREATE TABLE DEPARTMENTS (
         ID INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
         DEPT_NAME VARCHAR(45),
         LOCATION VARCHAR(90),
         BUDGET DECIMAL(12,2)
       )";
     if (!mysqli_query($connection, $query)) echo("<div class='error'>Erro ao criar tabela de departamentos.</div>");
  }
}

/* Verificar existência da tabela */
function TableExists($tableName, $connection, $dbName) {
  $t = mysqli_real_escape_string($connection, $tableName);
  $d = mysqli_real_escape_string($connection, $dbName);

  $checktable = mysqli_query($connection,
      "SELECT TABLE_NAME FROM information_schema.TABLES WHERE TABLE_NAME = '$t' AND TABLE_SCHEMA = '$d'");

  return (mysqli_num_rows($checktable) > 0);
}
?>