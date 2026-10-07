# Gestão SST — Pessoas & Segurança

Sistema web para controle de funcionários, EPIs, treinamentos (NRs) e emissão de certificados, com acesso controlado por cargo e permissões.

Construído com Laravel 13, PHP 8.3, Blade, Tailwind CSS 4 e Vite. Os testes usam Pest.

## Módulos

| Módulo | O que faz |
|---|---|
| Funcionários | Cadastro, edição, ativação/desativação, perfil e criação do usuário de acesso. |
| Cargos | Cargos de usuário (admin, gestor, colaborador…) e as permissões de cada um. |
| EPIs | Cadastro por CA e categoria, edição, ativação/desativação e exclusão. |
| Aulas | Treinamentos por norma, com aulas (datas e carga horária), EPIs vinculados, funcionários convocados e presença. |
| Certificados | Emissão para os funcionários elegíveis de uma aula e acompanhamento da validade. |
| Relatórios | Indicadores de pessoas, treinamentos e EPIs. |

### Regras dos treinamentos e certificados

- **Elegibilidade:** o funcionário é certificado quando a soma das horas das aulas em que compareceu é maior ou igual à carga mínima (`min_hours`) do treinamento. Não é exigida presença integral.
- **Conclusão:** o treinamento passa a "Concluído" quando todas as aulas planejadas são concluídas.
- **Emissão:** feita por confirmação manual ("Emitir certificados"), exige a permissão `certificates.allow` e só fica disponível com o treinamento concluído.
- **Validade:** informada em **meses** (`validity_months`) no treinamento. A data de vencimento do certificado é a data de emissão somada a esse número de meses.
- **EPIs do certificado:** a tabela `certificate_epis` guarda quais EPIs do treinamento valem para cada certificado.

## Permissões

O acesso é controlado por cargo (`user_roles`), que possui um conjunto de permissões (`permissions` e `role_permissions`). Cada permissão tem um `slug` no formato `recurso.ação`:

| Recurso | Slugs |
|---|---|
| Funcionários | `employees.view`, `employees.create`, `employees.update`, `employees.delete` |
| Treinamentos | `trainings.view`, `trainings.create`, `trainings.update`, `trainings.delete` |
| EPIs | `epis.view`, `epis.create`, `epis.update`, `epis.delete` |
| Relatórios | `reports.view`, `reports.create`, `reports.delete`, `reports.export` |
| Certificados | `certificates.allow` |

Como funciona:

- `User::hasPermission($slug)` consulta as permissões do cargo do usuário. Usuário sem cargo, ou com cargo inativo, não tem nenhuma permissão.
- Um `Gate::before` em `App\Providers\AppServiceProvider` libera a habilidade quando o cargo tem o slug. Caso contrário, deixa Gates e Policies decidirem.
- As rotas em `routes/web.php` são protegidas com `->middleware('can:<slug>')`. Sem permissão, a resposta é 403.
- As views usam `@can('<slug>')` para esconder botões, links e itens do menu. Isso é só interface: quem protege de verdade são as rotas.

Ainda sem permissão própria, e portanto liberadas a qualquer usuário autenticado: painel, cargos e a listagem de certificados.

Para criar uma permissão nova, adicione o par `name`/`slug` em `database/seeders/PermissionsSeeder.php`, vincule-a aos cargos em `RolePermissionSeeder` e proteja a rota com `can:<slug>`. A ordem do seeder importa, porque o `RolePermissionSeeder` referencia as permissões pelo id.

## Requisitos

- PHP 8.3 ou superior, com as extensões usuais do Laravel e o driver do banco escolhido
- Composer
- Node.js e npm
- MySQL, ou SQLite (padrão do `.env.example`)

## Instalação

```bash
composer setup
```

O script instala as dependências PHP e JS, cria o `.env` a partir do `.env.example`, gera a chave da aplicação, roda as migrations e compila os assets.

Para usar MySQL em vez de SQLite, ajuste o `.env` antes das migrations:

```dotenv
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=desafio
DB_USERNAME=root
DB_PASSWORD=
```

Depois, para recriar o banco já com dados de exemplo:

```bash
php artisan migrate:fresh --seed
```

> `migrate:fresh` apaga todas as tabelas. Use apenas em ambiente de desenvolvimento.

## Dados de exemplo

O seed cria setores, cargos da empresa, funcionários, categorias e EPIs, treinamentos com aulas e presenças e certificados em diferentes situações de validade (válido, a vencer e vencido), além dos cargos de usuário com suas permissões.

A senha de todos os usuários do seed é `123456`. Alguns logins:

| E-mail | Cargo | Permissões |
|---|---|---|
| `gustavo@gmail.com` | admin | todas |
| `mariana@gmail.com` | gestor | ver, criar, editar e apagar funcionários, treinamentos e EPIs, e ver/criar relatórios (sem emitir certificados nem exportar relatórios) |
| `camila@gmail.com` | colaborador | ver funcionários, treinamentos, EPIs e relatórios, e emitir certificados |

## Executando

```bash
composer dev
```

Sobe o servidor de desenvolvimento junto com o Vite. Se uma alteração de frontend não aparecer, rode `npm run build` ou deixe o `composer dev` ativo.

## Testes

```bash
php artisan test --compact
```

Os testes usam SQLite em memória (`phpunit.xml`), então a extensão `pdo_sqlite` precisa estar instalada. Para rodar contra outro banco, defina `DB_CONNECTION` e `DB_DATABASE` na própria execução, **sempre apontando para um banco descartável**, porque os testes refazem o schema:

```bash
DB_CONNECTION=mysql DB_DATABASE=desafio_test php artisan test --compact
```

Os helpers de teste, como `userWithPermissions()`, ficam em `tests/Pest.php`.

## Padrão de código

O projeto usa o [Laravel Pint](https://laravel.com/docs/pint):

```bash
vendor/bin/pint --dirty
```

## Licença

Projeto baseado no Laravel, que é um software de código aberto sob a [licença MIT](https://opensource.org/licenses/MIT).
