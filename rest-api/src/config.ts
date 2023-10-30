import { PoolConfig } from "pg";

export const dbConfig: PoolConfig = {
  user: process.env.DB_USER ?? "", // default process.env.PGUSER || process.env.USER
  password: process.env.DB_PASSWORD ?? "", //default process.env.PGPASSWORD
  host: "localhost",
  database: process.env.DB_NAME ?? "", // default process.env.PGDATABASE || user
  port: Number(process.env.DB_PORT) ?? 3000, // default process.env.PGPORT
  max: 20,
  idleTimeoutMillis: 30000,
  connectionTimeoutMillis: 2000,
};
