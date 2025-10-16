# 🩺 Med.IA - Sistema de Diagnóstico Médico Assistido por IA

![Med.IA](https://img.shields.io/badge/Med-IA-blue) ![Laravel](https://img.shields.io/badge/Laravel-10.x-red) ![MySQL](https://img.shields.io/badge/MySQL-8.0-orange) ![AI-Powered](https://img.shields.io/badge/AI--Powered-DeepSeek-green)

Sistema inteligente de apoio ao diagnóstico médico que combina banco de dados especializado com inteligência artificial para fornecer diagnósticos preliminares precisos e rápidos.

## ✨ Funcionalidades Principais

- **🤖 Diagnóstico Híbrido**: Combina banco de dados médico local com IA (DeepSeek API)
- **💾 Base de Conhecimento Crescente**: Aprende e armazena novos diagnósticos automaticamente
- **⚡ Performance Otimizada**: Busca local primeiro, API apenas para refinamento
- **🎯 Interface Intuitiva**: Design moderno e responsivo com Tailwind CSS
- **📊 Resultados Detalhados**: Diagnóstico, gravidade, medicamentos, exames e recomendações
- **🔒 Segurança Médica**: Sempre recomenda consulta presencial como follow-up

## 🛠️ Tecnologias Utilizadas

- **Backend**: Laravel 10.x
- **Frontend**: Tailwind CSS, Blade Templates
- **Banco de Dados**: MySQL 8.0
- **IA**: DeepSeek API
- **Autenticação**: Laravel Breeze (opcional)
- **Deploy**: Compatível com Laravel Forge/Vapor

## 📋 Pré-requisitos

- PHP 8.1+
- Composer
- MySQL 8.0+
- Node.js & NPM
- Conta na [DeepSeek API](https://platform.deepseek.com/) (opcional)

## 🚀 Instalação Rápida

### 1. Clone o repositório

```bash
git clone https://github.com/seu-usuario/med-ia.git
cd med-ia
```

### 2. Instale as dependências PHP

```bash
composer install
```

### 3. Instale as dependências Frontend

```bash
npm install && npm run build
```

### 4. Configure o ambiente

```bash
cp .env.example .env
php artisan key:generate
```

### 5. Configure o banco de dados

Edite o arquivo `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=med_ia
DB_USERNAME=seu_usuario
DB_PASSWORD=sua_senha

# Opcional: DeepSeek API
DEEPSEEK_API_KEY=sua_chave_aqui
```

### 6. Execute as migrations e seeders

```bash
php artisan migrate
php artisan db:seed --class=DiagnosticosSeeder
```

### 7. Inicie o servidor

```bash
php artisan serve
```

Acesse: `http://localhost:8000`

## 🎯 Como Usar

### Diagnóstico Básico (Sem API)

1. Acesse a página de consulta
2. Descreva os sintomas do paciente
3. Receba diagnóstico baseado no banco de dados local
4. Visualize resultados detalhados com tratamentos sugeridos

### Diagnóstico com IA (Recomendado)

1. Registre-se na [DeepSeek API](https://platform.deepseek.com/)
2. Adicione sua chave no `.env`
3. O sistema irá refinar diagnósticos automaticamente

## 🗂️ Estrutura do Projeto

```
med-ia/
├── app/
│   ├── Models/
│   │   └── Diagnostico.php
│   ├── Http/
│   │   └── Controllers/
│   │       └── DiagnosticoController.php
│   └── Providers/
├── database/
│   ├── migrations/
│   │   └── create_diagnosticos_table.php
│   └── seeders/
│       └── DiagnosticosSeeder.php
├── resources/
│   ├── views/
│   │   ├── consulta.blade.php
│   │   └── resultado.blade.php
│   └── css/
├── routes/
│   └── web.php
└── config/
```

## 🔧 Comandos Úteis

```bash
# Popular banco com dados médicos
php artisan db:seed --class=DiagnosticosSeeder

# Limpar cache
php artisan config:clear
php artisan cache:clear

# Criar novo diagnóstico manualmente
php artisan tinker
>>> App\Models\Diagnostico::create([...])
```

## 🧪 Dados de Exemplo Incluídos

O seeder inclui diagnósticos para:

- ✅ Dengue Clássica
- ✅ Virose Comum
- ✅ Faringite Aguda
- ✅ Amigdalite
- ✅ Gastroenterite

## 🔐 Variáveis de Ambiente

| Variável            | Descrição           | Obrigatório              |
| -------------------- | --------------------- | ------------------------- |
| `DEEPSEEK_API_KEY` | Chave da API DeepSeek | Não                      |
| `DB_CONNECTION`    | Tipo de banco (mysql) | Sim                       |
| `DB_DATABASE`      | Nome do banco         | Sim                       |
| `APP_DEBUG`        | Modo debug            | Sim (false em produção) |

## 🤝 Contribuindo

1. Fork o projeto
2. Crie uma branch: `git checkout -b feature/nova-funcionalidade`
3. Commit suas mudanças: `git commit -m 'Adiciona nova funcionalidade'`
4. Push para a branch: `git push origin feature/nova-funcionalidade`
5. Abra um Pull Request

### Áreas para Contribuição

- 📚 Expansão da base de dados médica
- 🎨 Melhorias na interface
- 🔍 Algoritmos de busca semântica
- 🌐 Traduções para outros idiomas

## ⚠️ Aviso Legal

**Este sistema é apenas para apoio diagnóstico e não substitui a consulta médica profissional.**

- Todos os diagnósticos são preliminares
- Sempre recomende consulta presencial
- Mantenha sigilo dos dados dos pacientes
- Use conforme regulamentações médicas locais

## 📄 Licença

Este projeto está sob a licença MIT. Veja o arquivo [LICENSE](LICENSE) para detalhes.

## 🆘 Suporte

Encontrou problemas?

1. Verifique as [Issues](https://github.com/seu-usuario/med-ia/issues)
2. Crie uma nova issue com detalhes do problema
3. Entre em contato: seu-email@dominio.com

## 🚀 Próximas Atualizações

- [ ] Integração com mais APIs de IA
- [ ] Busca semântica com embeddings
- [ ] App mobile
- [ ] Multi-idioma
- [ ] Dashboard administrativo

---

**Desenvolvido com ❤️ para a comunidade médica**

*"Tecnologia a serviço da saúde"* 🩺⚡
