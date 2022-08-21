<template>
    <div class="project-list-item">
        <slot></slot>
    </div>
</template>

<style>
    .project-list-item {
        padding: 1rem;
        border-radius: 4px;
        background-color: #ddd;
        display: flex;
    }
    .project-list-item:not(:last-child) {
        margin-bottom: .2rem;
    }
</style>
