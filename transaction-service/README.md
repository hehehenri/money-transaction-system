# Transactions Service

### Problemas de Consistência

Envio do email de confirmação:

- Pior caso: Uma transação é criada, aprovada e antes do serviço de envio de emails ser chamado, o serviço cai.
- Consequência: Quando o serviço subir novamente, o processo da criação da transação já vai ter se encerrado. 
Consequentemente o email de confirmação nunca vai ser enviado.
- Solução: Criar um evento de criação de transação quando uma transação é recebida e processada. Um processo rodando em
background vai buscar por eventos de transação, chamar o serviço de envio de email e marcar o evento como processado.
- Referências: https://learn.microsoft.com/en-us/azure/architecture/best-practices/transactional-outbox-cosmos

Comunicar com o serviço de aprovação de transações

- Pior caso: O serviço está offline devido a muitas requisições feitas pelo nosso serviço.
- Consequências: Continuar enviando requisições pro serviço, impedindo que ele se recupere.
- Solução: Implementar um circuit breaker aos clientes que comunicam com esse serviço externo.
- Referências: https://martinfowler.com/bliki/CircuitBreaker.html

