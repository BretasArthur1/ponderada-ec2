# Aplicação Web com AWS EC2, MySQL, PHP e Apache

Este repositório contém o código-fonte e a documentação de uma aplicação web desenvolvida como parte de uma atividade ponderada. A aplicação permite gerenciar funcionários e departamentos através de uma interface web, armazenando e recuperando dados de um banco de dados MySQL hospedado em uma instância EC2 da AWS.

## Descrição do Projeto

O projeto consiste em uma aplicação web para gerenciamento de recursos humanos, com as seguintes funcionalidades:

- Cadastro de funcionários (nome, endereço, idade e salário)
- Visualização dos funcionários cadastrados
- Cadastro de departamentos (nome, localização e orçamento)
- Visualização dos departamentos cadastrados
- Armazenamento persistente dos dados em um banco de dados MySQL
- Interface de usuário moderna e responsiva

A aplicação foi desenvolvida utilizando as seguintes tecnologias:

- **AWS EC2**: Para hospedar a aplicação web
- **MySQL**: Como sistema de gerenciamento de banco de dados
- **PHP**: Para a lógica de backend e interação com o banco de dados
- **Apache**: Como servidor web para servir a aplicação
- **HTML/CSS**: Para a interface do usuário

## Estrutura do Repositório

- `employees.php`: Arquivo principal da aplicação, contendo o código PHP para interação com o banco de dados e a interface de usuário
- `inc/dbinfo.inc`: Arquivo de configuração com as credenciais do banco de dados (não incluído no repositório por segurança)

## Estrutura do Banco de Dados

A aplicação utiliza duas tabelas principais:

### Tabela EMPLOYEES
- **ID**: Identificador único (chave primária)
- **NAME**: Nome do funcionário
- **ADDRESS**: Endereço do funcionário
- **AGE**: Idade do funcionário
- **SALARY**: Salário do funcionário

### Tabela DEPARTMENTS
- **ID**: Identificador único (chave primária)
- **DEPT_NAME**: Nome do departamento
- **LOCATION**: Localização do departamento
- **BUDGET**: Orçamento do departamento

## Interface do Usuário

A aplicação possui uma interface moderna e intuitiva, com as seguintes características:

- Design responsivo que se adapta a diferentes tamanhos de tela
- Formulários organizados com validação de campos
- Tabelas com formatação clara para visualização dos dados
- Mensagens de feedback para ações do usuário
- Estilização com CSS para melhor experiência visual

## Configuração do Ambiente

### Pré-requisitos

- Uma conta AWS
- Conhecimentos básicos de EC2, MySQL, PHP e Apache

### Passos para Configuração

1. **Criação da Instância EC2**:
   - Acesse o console da AWS e crie uma instância EC2
   - Selecione uma AMI com suporte para PHP e Apache
   - Configure os grupos de segurança para permitir tráfego HTTP (porta 80) e MySQL (porta 3306)
   - Crie e baixe um par de chaves para acesso SSH

2. **Instalação e Configuração do MySQL**:
   - Conecte-se à instância EC2 via SSH
   - Instale o MySQL Server
   - Configure um usuário e senha para o banco de dados
   - Crie um banco de dados para a aplicação

3. **Configuração do Apache e PHP**:
   - Instale o Apache e PHP na instância EC2
   - Configure o Apache para servir arquivos PHP
   - Reinicie o serviço Apache

4. **Implantação da Aplicação**:
   - Clone este repositório na instância EC2
   - Crie o arquivo `inc/dbinfo.inc` com as credenciais do banco de dados
   - Coloque os arquivos no diretório raiz do Apache

## Uso da Aplicação

1. Acesse a aplicação através do endereço IP público da instância EC2
2. Na seção "Gerenciamento de Funcionários":
   - Preencha o formulário com os dados do funcionário
   - Clique em "Adicionar Funcionário"
   - Visualize os funcionários cadastrados na tabela abaixo
3. Na seção "Gerenciamento de Departamentos":
   - Preencha o formulário com os dados do departamento
   - Clique em "Adicionar Departamento"
   - Visualize os departamentos cadastrados na tabela abaixo

## Segurança

Para garantir a segurança da aplicação:

- O arquivo de configuração com as credenciais do banco de dados não está incluído no repositório
- A aplicação utiliza `mysqli_real_escape_string` para prevenir injeção de SQL
- Os dados do formulário são sanitizados antes de serem inseridos no banco de dados
- Validação de tipos de dados para campos numéricos

## Vídeo Explicativo

Para uma explicação detalhada sobre o desenvolvimento e funcionamento deste projeto, assista ao vídeo explicativo através do link abaixo:

[Link para o vídeo explicativo]()

## Autor

Arthur Bretas Oliveira

## Licença

Este projeto está licenciado sob a licença MIT - veja o arquivo LICENSE para mais detalhes.
