/** source/controllers/posts.ts */
import { Request, Response, NextFunction } from "express";
import { Pool } from "pg";
import { dbConfig } from "../config";

const pool = new Pool(dbConfig);

// getting all posts
const getPosts = async (req: Request, res: Response, next: NextFunction) => {
  try {
    const queryString = "SELECT * FROM posts";
    const { rows } = await pool.query({ text: queryString });
    return res.status(200).json({
      message: "you called get posts",
      data: rows,
    });
  } catch (err) {
    console.error(err);
    return res.status(500).json({
      error: err,
    });
  }
};

// getting a single post
const getPost = async (req: Request, res: Response, next: NextFunction) => {
  try {
    const { id } = req.params;
    const query = "SELECT * FROM posts WHERE id = $1;";

    const { rows } = await pool.query(query, [id]);
    if (rows.length === 0) {
      return res.status(404).send("this album is not in the database");
    }

    return res.status(200).json({
      data: rows[0],
    });
  } catch (err) {
    console.error(err);
    res.status(500).json({
      error: err,
    });
  }
};

// updating a post
const updatePost = async (req: Request, res: Response, next: NextFunction) => {
  try {
    const { id } = req.params;
    const { body } = req.body;

    if (!body) {
      return res.status(400).send("provide a field (body)");
    }

    const query = `
      UPDATE posts
      SET body = COALESCE($1, body)
      WHERE id = $2
      RETURNING *;
    `;
    const { rows } = await pool.query(query, [body, id]);

    if (rows.length === 0) {
      return res.status(404).send(`Post with id: ${id} not found`);
    }

    res.status(200).json({ data: rows[0] });
  } catch (err) {
    console.error(err);
    res.status(500).send("Internal server error");
  }
};

// deleting a post
const deletePost = async (req: Request, res: Response, next: NextFunction) => {
  try {
    const { id } = req.params;
    const query = "DELETE FROM posts WHERE id = $1 RETURNING *;";
    const { rows } = await pool.query(query, [id]);

    if (rows.length === 0) {
      return res.status(404).send("Post not found");
    }

    res.status(200).json({ data: rows[0] });
  } catch (err) {
    console.error(err);
    res.status(500).send("Internal error");
  }
};

// adding a post
const addPost = async (req: Request, res: Response, next: NextFunction) => {
  // Validate the incoming JSON data
  const { userId, groupId, threadId, body } = req.body;
  if (!userId || !groupId || !threadId || !body) {
    return res
      .status(400)
      .send(
        "Any one of the following: userId, groupId, threadId or body is missing in the data"
      );
  }

  try {
    // try to send data to the database
    const query = `
      INSERT INTO posts (user_id, group_id, thread_id, body)
      VALUES ($1, $2, $3, $4)
      RETURNING id;
    `;
    const values = [userId, groupId, threadId, body];

    const result = await pool.query(query, values);
    res
      .status(201)
      .send({ message: "New post created", postId: result.rows[0].id });
  } catch (err) {
    console.error(err);
    res.status(500).send("Internal server error");
  }
};

export default { getPosts, getPost, updatePost, deletePost, addPost };
