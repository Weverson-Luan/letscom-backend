# 🧾Etapas do processo de remessa:

solicitado -> Cliente solicitou

em_producao -> Produção iniciou a remessa

expedicao -> Produção finalizou a remessa

pedido_liberado -> Expedição liberou a remessa

entregue -> Recepção deu baixa

# ✅Ordem recomendada para organização:

Repository
Lida com o banco de dados (buscas, atualizações, filtros).

Service
Contém a lógica de negócio. Recebe os dados do controller e usa o repository para interagir com o banco.

Controller
Responsável por receber a requisição, validar os dados e chamar os métodos do service.

📦 Como grandes empresas geralmente tratam erros (nível produção):
Prática O que é/como funciona
✅ FormRequest classes Separa as validações em classes (UserStoreRequest, etc.)
✅ Response padrão (API Resource) Todos os retornos seguem um padrão comum { message, errors, data }
✅ Tratamento global de exceções Um middleware ou handler (app/Exceptions/Handler.php) captura tudo
✅ Logs estruturados Logs vão para serviços como Sentry, DataDog, CloudWatch etc.
✅ Mensagens claras e auditáveis Evita leaks de SQL, mostra mensagens legíveis para o frontend ou cliente
