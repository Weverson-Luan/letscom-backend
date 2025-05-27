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
