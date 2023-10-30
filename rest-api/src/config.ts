import { ClientConfig } from "pg";

export const dbConfig: ClientConfig = {
  user: process.env.DB_USER ?? "", // default process.env.PGUSER || process.env.USER
  password: process.env.DB_PASSWORD ?? "", //default process.env.PGPASSWORD
  host: "localhost",
  database: process.env.DB_NAME ?? "", // default process.env.PGDATABASE || user
  port: Number(process.env.DB_PORT) ?? 3000, // default process.env.PGPORT
  statement_timeout: 2000, // number of milliseconds before a statement in query will time out, default is no timeout
  query_timeout: 2000, // number of milliseconds before a query call will timeout, default is no timeout
  application_name: "iis-rest-api", // The name of the application that created this Client instance
  connectionTimeoutMillis: 2000, // number of milliseconds to wait for connection, default is no timeout
};
