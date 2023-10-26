import express from "express";
import PostController from "./Controllers/PostController";
const router = express.Router();

// posts
router.get("/posts", PostController.getPosts);
router.get("/posts/:id", PostController.getPost);
router.put("/posts/:id", PostController.updatePost);
router.delete("/posts/:id", PostController.deletePost);
router.post("/posts", PostController.addPost);

export = router;
